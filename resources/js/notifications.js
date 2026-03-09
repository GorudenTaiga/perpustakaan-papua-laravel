/**
 * Real-time Browser Notifications via Server-Sent Events (SSE)
 *
 * The browser holds a single persistent connection to /notifications/stream.
 * The server pushes events within ~3 seconds of a notification being created.
 * No page refresh needed. EventSource auto-reconnects if the connection drops.
 */

const STORAGE_KEY  = 'perpus_notif_last_check';
const DISMISSED_KEY = 'perpus_notif_prompt_dismissed';
const PROMPT_ID    = 'browser-notif-prompt';

/* ─── Config injected from Blade layout ─────────────────────────────── */
const cfg        = window.__notifConfig || {};
const streamUrl  = cfg.streamUrl  || '/notifications/stream';
const countUrl   = cfg.countUrl   || '/notifications/unread-count';
const notifUrl   = cfg.notifUrl   || '/notifications';
const iconUrl    = cfg.iconUrl    || '/favicon.ico';

let eventSource  = null;

/* ─── Helpers ────────────────────────────────────────────────────────── */
function supported() {
    return 'Notification' in window && 'EventSource' in window;
}

function getLastCheck() {
    return localStorage.getItem(STORAGE_KEY) || new Date(Date.now() - 10_000).toISOString();
}

function setLastCheck(ts) {
    localStorage.setItem(STORAGE_KEY, ts);
}

/* ─── Show a single browser notification ────────────────────────────── */
function showBrowserNotification(notif) {
    if (Notification.permission !== 'granted') return;

    const n = new Notification(notif.title, {
        body  : notif.message,
        icon  : iconUrl,
        badge : iconUrl,
        tag   : `perpus-notif-${notif.id}`,
    });

    n.onclick = () => {
        window.focus();
        window.location.href = notifUrl;
        n.close();
    };

    setTimeout(() => n.close(), 8_000);
}

/* ─── Update the unread badge in the navbar bell ────────────────────── */
async function updateNavBadge() {
    try {
        const res = await fetch(countUrl, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const { count } = await res.json();

        document.querySelectorAll('[data-notif-badge]').forEach(el => {
            el.textContent = count > 9 ? '9+' : String(count);
            el.style.display = count > 0 ? '' : 'none';
        });
    } catch (_) {}
}

/* ─── Open SSE connection ────────────────────────────────────────────── */
function connectSSE() {
    if (Notification.permission !== 'granted') return;
    if (eventSource) {
        eventSource.close();
        eventSource = null;
    }

    const since = getLastCheck();
    const url   = `${streamUrl}?since=${encodeURIComponent(since)}`;

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
        // EventSource will automatically reconnect (server sends retry: 3000).
        // We only need to update the 'since' param on reconnect, which happens
        // naturally because we stored it in localStorage via setLastCheck().
        eventSource.close();
        eventSource = null;
        // Reconnect after a short back-off (the server also sends retry: 3000)
        setTimeout(connectSSE, 5_000);
    };
}

/* ─── Permission prompt (dismissible bottom-right card) ─────────────── */
function showPermissionPrompt() {
    if (localStorage.getItem(DISMISSED_KEY)) return;
    if (document.getElementById(PROMPT_ID)) return;

    const prompt = document.createElement('div');
    prompt.id = PROMPT_ID;
    prompt.innerHTML = `
        <div class="fixed bottom-5 right-5 z-[9999] max-w-sm w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: slideUp .3s ease">
            <style>@keyframes slideUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}</style>
            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Aktifkan Notifikasi Real-time</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        Terima notifikasi langsung — peminjaman, buku baru, dan pengingat, tanpa perlu refresh halaman.
                    </p>
                </div>
                <button id="${PROMPT_ID}-close" class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors text-lg">
                    &times;
                </button>
            </div>
            <div class="flex gap-2 px-4 pb-4">
                <button id="${PROMPT_ID}-allow" class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    Ya, Aktifkan
                </button>
                <button id="${PROMPT_ID}-later" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-xl transition-colors">
                    Nanti Saja
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(prompt);

    document.getElementById(`${PROMPT_ID}-close`).addEventListener('click', () => {
        localStorage.setItem(DISMISSED_KEY, '1');
        prompt.remove();
    });

    document.getElementById(`${PROMPT_ID}-later`).addEventListener('click', () => {
        prompt.remove(); // Ask again next session
    });

    document.getElementById(`${PROMPT_ID}-allow`).addEventListener('click', async () => {
        prompt.remove();
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            connectSSE();
            showBrowserNotification({
                id     : 'welcome',
                title  : '🔔 Notifikasi Aktif',
                message: 'Kamu akan menerima notifikasi secara real-time dari perpustakaan.',
            });
        } else {
            localStorage.setItem(DISMISSED_KEY, '1');
        }
    });
}

/* ─── Entry point ────────────────────────────────────────────────────── */
function init() {
    if (!supported()) return;

    if (Notification.permission === 'granted') {
        connectSSE();
    } else if (Notification.permission === 'default') {
        setTimeout(showPermissionPrompt, 3_000);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

