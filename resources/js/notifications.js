/**
 * Notification system — zero continuous polling.
 *
 * Badge counter updates ONLY when:
 *  1. Page first loads (one fetch)
 *  2. Tab becomes visible again after being hidden
 *  3. Service Worker pushes a message (Web Push received)
 *
 * Browser popup shown ONLY when:
 *  - Web Push is received from server (triggered by actual events)
 *
 * No setInterval. No SSE. Zero idle server cost.
 */

const DISMISSED_KEY = 'perpus_notif_prompt_dismissed';
const PROMPT_ID     = 'browser-notif-prompt';

const POPUP_TYPES = new Set([
    'peminjaman',
    'deadline_peminjaman',
    'denda',
    'reservation',
    'reservasi',
    'loan_extended',
    'verifikasi_akun',
]);

/* ─── Config injected from Blade layout ─────────────────────────────── */
const cfg          = window.__notifConfig || {};
const countUrl     = cfg.countUrl     || '/notifications/unread-count';
const notifUrl     = cfg.notifUrl     || '/notifications';
const iconUrl      = cfg.iconUrl      || '/favicon.ico';
const vapidKeyUrl  = cfg.vapidKeyUrl  || '/notifications/vapid-key';
const subscribeUrl = cfg.subscribeUrl || '/notifications/push/subscribe';
const unsubUrl     = cfg.unsubUrl     || '/notifications/push/unsubscribe';
const csrfToken    = document.querySelector('meta[name="csrf-token"]')?.content || '';

/* ─── Helpers ────────────────────────────────────────────────────────── */
function supported() {
    return 'Notification' in window && 'serviceWorker' in navigator && 'PushManager' in window;
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw     = atob(base64);
    return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
}

/* ─── Navbar badge: one HTTP call per trigger, never looping ────────── */
async function updateNavBadge() {
    try {
        const res = await fetch(countUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const { count } = await res.json();
        document.querySelectorAll('[data-notif-badge]').forEach(el => {
            el.textContent   = count > 9 ? '9+' : String(count);
            el.style.display = count > 0 ? '' : 'none';
        });
    } catch (_) {}
}

/* ─── Listen for messages from Service Worker ───────────────────────── */
function listenServiceWorkerMessages() {
    navigator.serviceWorker.addEventListener('message', (event) => {
        if (event.data?.type === 'NEW_NOTIFICATION') {
            // Only update badge — popup is already handled by the SW push event
            updateNavBadge();
        }
    });
}

/* ─── Refresh badge when tab becomes visible again ──────────────────── */
function listenVisibilityChange() {
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            updateNavBadge();
        }
    });
}

/* ─── Web Push subscription ─────────────────────────────────────────── */
async function subscribePush(registration) {
    try {
        const keyRes  = await fetch(vapidKeyUrl, { credentials: 'same-origin' });
        const { key } = await keyRes.json();
        if (!key) return;

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly      : true,
            applicationServerKey : urlBase64ToUint8Array(key),
        });
        const keys = subscription.toJSON().keys;

        await fetch(subscribeUrl, {
            method      : 'POST',
            credentials : 'same-origin',
            headers     : {
                'Content-Type' : 'application/json',
                'Accept'       : 'application/json',
                'X-CSRF-TOKEN' : csrfToken,
            },
            body: JSON.stringify({
                endpoint : subscription.endpoint,
                p256dh   : keys.p256dh,
                auth     : keys.auth,
            }),
        });
    } catch (err) {
        console.debug('[Push] Subscription failed:', err.message);
    }
}

/* ─── Service Worker registration ───────────────────────────────────── */
async function registerServiceWorker() {
    try {
        const registration = await navigator.serviceWorker.register('/sw.js', { scope: '/' });
        await navigator.serviceWorker.ready;
        return registration;
    } catch (err) {
        console.debug('[SW] Registration failed:', err.message);
        return null;
    }
}

/* ─── Permission prompt ──────────────────────────────────────────────── */
function showPermissionPrompt(onAllow) {
    if (localStorage.getItem(DISMISSED_KEY)) return;
    if (document.getElementById(PROMPT_ID)) return;

    const prompt = document.createElement('div');
    prompt.id = PROMPT_ID;
    prompt.innerHTML = `
        <div class="fixed bottom-5 right-5 z-[9999] max-w-sm w-full bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="animation:slideUp .3s ease">
            <style>@keyframes slideUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}</style>
            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900">Aktifkan Notifikasi</p>
                    <p class="mt-0.5 text-xs text-gray-500 leading-relaxed">
                        Terima notifikasi penting bahkan saat website sedang tidak dibuka.
                    </p>
                </div>
                <button id="${PROMPT_ID}-close" class="w-6 h-6 flex items-center justify-center rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors text-lg">&times;</button>
            </div>
            <div class="flex gap-2 px-4 pb-4">
                <button id="${PROMPT_ID}-allow" class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors">Ya, Aktifkan</button>
                <button id="${PROMPT_ID}-later" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl transition-colors">Nanti Saja</button>
            </div>
        </div>`;

    document.body.appendChild(prompt);

    document.getElementById(`${PROMPT_ID}-close`).onclick = () => {
        localStorage.setItem(DISMISSED_KEY, '1'); prompt.remove();
    };
    document.getElementById(`${PROMPT_ID}-later`).onclick  = () => prompt.remove();
    document.getElementById(`${PROMPT_ID}-allow`).onclick  = async () => {
        prompt.remove();
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            await onAllow();
        } else {
            localStorage.setItem(DISMISSED_KEY, '1');
        }
    };
}

/* ─── Entry point ────────────────────────────────────────────────────── */
async function init() {
    if (!supported()) return;

    // Fetch badge once on page load — no loop
    updateNavBadge();

    // Update badge when tab becomes visible
    listenVisibilityChange();

    const registration = await registerServiceWorker();

    const activate = async () => {
        listenServiceWorkerMessages();
        if (registration) await subscribePush(registration);
    };

    if (Notification.permission === 'granted') {
        await activate();
    } else if (Notification.permission === 'default') {
        setTimeout(() => showPermissionPrompt(activate), 3_000);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
