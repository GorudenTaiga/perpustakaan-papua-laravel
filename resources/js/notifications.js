/**
 * Real-time notifications: SSE (tab open) + Web Push (background/closed).
 *
 * Flow:
 *  1. Page loads → register Service Worker
 *  2. Prompt user for notification permission
 *  3. On grant → subscribe to Web Push + open SSE stream
 *  4. SSE delivers while tab is open (~3s latency)
 *  5. Web Push delivers even when website is closed
 */

const STORAGE_KEY   = 'perpus_notif_last_check';
const DISMISSED_KEY = 'perpus_notif_prompt_dismissed';
const PROMPT_ID     = 'browser-notif-prompt';

// How long (ms) to wait before reconnecting after an SSE error.
// Should be >= server poll interval (15s) to avoid hammering the server.
const RECONNECT_DELAY_MS = 15_000;

/* ─── Config injected from Blade layout ─────────────────────────────── */
const cfg           = window.__notifConfig || {};
const streamUrl     = cfg.streamUrl     || '/notifications/stream';
const countUrl      = cfg.countUrl      || '/notifications/unread-count';
const notifUrl      = cfg.notifUrl      || '/notifications';
const iconUrl       = cfg.iconUrl       || '/favicon.ico';
const vapidKeyUrl   = cfg.vapidKeyUrl   || '/notifications/vapid-key';
const subscribeUrl  = cfg.subscribeUrl  || '/notifications/push/subscribe';
const unsubUrl      = cfg.unsubUrl      || '/notifications/push/unsubscribe';
const csrfToken     = document.querySelector('meta[name="csrf-token"]')?.content || '';

let eventSource = null;

/* ─── Helpers ────────────────────────────────────────────────────────── */
function supported() {
    return 'Notification' in window && 'serviceWorker' in navigator && 'PushManager' in window;
}

function setLastCheck(ts) { localStorage.setItem(STORAGE_KEY, ts); }
function getLastCheck()   { return localStorage.getItem(STORAGE_KEY) || new Date(Date.now() - 10_000).toISOString(); }

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw     = atob(base64);
    return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
}

/* ─── Navbar badge update ────────────────────────────────────────────── */
async function updateNavBadge() {
    try {
        const res = await fetch(countUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const { count } = await res.json();
        document.querySelectorAll('[data-notif-badge]').forEach(el => {
            el.textContent    = count > 9 ? '9+' : String(count);
            el.style.display  = count > 0 ? '' : 'none';
        });
    } catch (_) {}
}

/* ─── Show browser notification (for SSE path) ──────────────────────── */
function showBrowserNotification(notif) {
    if (Notification.permission !== 'granted') return;
    const n = new Notification(notif.title, {
        body  : notif.message,
        icon  : iconUrl,
        badge : iconUrl,
        tag   : `perpus-notif-${notif.id}`,
    });
    n.onclick = () => { window.focus(); window.location.href = notifUrl; n.close(); };
    setTimeout(() => n.close(), 8_000);
}

/* ─── SSE: real-time while page is open ─────────────────────────────── */
function connectSSE() {
    if (Notification.permission !== 'granted') return;
    if (eventSource) { eventSource.close(); eventSource = null; }

    const url = `${streamUrl}?since=${encodeURIComponent(getLastCheck())}`;
    eventSource = new EventSource(url, { withCredentials: true });

    eventSource.addEventListener('notification', (e) => {
        try {
            const notif = JSON.parse(e.data);
            showBrowserNotification(notif);
            setLastCheck(new Date().toISOString());
            updateNavBadge();
        } catch (_) {}
    });

    eventSource.onerror = () => {
        eventSource.close();
        eventSource = null;
        setTimeout(connectSSE, RECONNECT_DELAY_MS);
    };
}

/* ─── Web Push: subscribe so notifications arrive when tab is closed ── */
async function subscribePush(registration) {
    try {
        // Get VAPID public key from server
        const keyRes  = await fetch(vapidKeyUrl, { credentials: 'same-origin' });
        const { key } = await keyRes.json();
        if (!key) return;

        const applicationServerKey = urlBase64ToUint8Array(key);

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly      : true,
            applicationServerKey : applicationServerKey,
        });

        const keys = subscription.toJSON().keys;

        // Send subscription to server
        await fetch(subscribeUrl, {
            method      : 'POST',
            credentials : 'same-origin',
            headers     : {
                'Content-Type'  : 'application/json',
                'Accept'        : 'application/json',
                'X-CSRF-TOKEN'  : csrfToken,
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
        <div class="fixed bottom-5 right-5 z-[9999] max-w-sm w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation:slideUp .3s ease">
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
                        Terima notifikasi real-time bahkan saat website sedang tidak dibuka.
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
    document.getElementById(`${PROMPT_ID}-later`).onclick = () => prompt.remove();
    document.getElementById(`${PROMPT_ID}-allow`).onclick = async () => {
        prompt.remove();
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            await onAllow();
            showBrowserNotification({ id: 'welcome', title: '🔔 Notifikasi Aktif', message: 'Kamu akan menerima notifikasi bahkan saat website ditutup.' });
        } else {
            localStorage.setItem(DISMISSED_KEY, '1');
        }
    };
}

/* ─── Entry point ────────────────────────────────────────────────────── */
async function init() {
    if (!supported()) return;

    const registration = await registerServiceWorker();

    const activate = async () => {
        connectSSE();
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


