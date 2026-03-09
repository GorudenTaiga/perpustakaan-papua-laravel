/**
 * Browser Push Notifications (Web Notifications API + polling)
 * Requests permission once, then polls /notifications/latest every 30s.
 * Content is taken directly from the Notification records in the database.
 */

const POLL_INTERVAL   = 30_000; // 30 seconds
const STORAGE_KEY     = 'perpus_notif_last_check';
const DISMISSED_KEY   = 'perpus_notif_prompt_dismissed';
const PROMPT_ID       = 'browser-notif-prompt';

/* ─── Config injected from the Blade layout ──────────────────────────── */
const cfg = window.__notifConfig || {};
const latestUrl  = cfg.latestUrl  || '/notifications/latest';
const notifUrl   = cfg.notifUrl   || '/notifications';
const iconUrl    = cfg.iconUrl    || '/favicon.ico';
const csrfToken  = cfg.csrfToken  || document.querySelector('meta[name="csrf-token"]')?.content || '';

/* ─── Helpers ─────────────────────────────────────────────────────────── */
function supported() {
    return 'Notification' in window;
}

function getLastCheck() {
    return localStorage.getItem(STORAGE_KEY) || null;
}

function setLastCheck(ts) {
    localStorage.setItem(STORAGE_KEY, ts);
}

/* ─── Show a single browser notification ─────────────────────────────── */
function showBrowserNotification(notif) {
    if (Notification.permission !== 'granted') return;

    const n = new Notification(notif.title, {
        body   : notif.message,
        icon   : iconUrl,
        badge  : iconUrl,
        tag    : `perpus-notif-${notif.id}`,
        silent : false,
    });

    n.onclick = () => {
        window.focus();
        window.location.href = notifUrl;
        n.close();
    };

    // Auto-close after 8 seconds
    setTimeout(() => n.close(), 8_000);
}

/* ─── Poll endpoint for new notifications ────────────────────────────── */
async function pollNotifications() {
    if (Notification.permission !== 'granted') return;

    const since    = getLastCheck();
    const newCheck = new Date().toISOString();

    try {
        const params = since ? `?since=${encodeURIComponent(since)}` : '';
        const res = await fetch(`${latestUrl}${params}`, {
            headers: {
                'Accept'          : 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN'    : csrfToken,
            },
            credentials: 'same-origin',
        });

        if (!res.ok) return;

        const data = await res.json();
        const notifications = data.notifications || [];

        // Show browser notification for each new entry
        notifications.forEach(n => showBrowserNotification(n));

        // Update badge in navbar if any came in
        if (notifications.length > 0) {
            updateNavBadge();
        }
    } catch (_) {
        // Silently ignore network errors
    } finally {
        setLastCheck(newCheck);
    }
}

/* ─── Dynamically update the unread badge in the nav bell ────────────── */
async function updateNavBadge() {
    try {
        const res = await fetch('/notifications/unread-count', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const { count } = await res.json();

        document.querySelectorAll('[data-notif-badge]').forEach(el => {
            if (count > 0) {
                el.textContent = count > 9 ? '9+' : String(count);
                el.style.display = '';
            } else {
                el.style.display = 'none';
            }
        });
    } catch (_) {}
}

/* ─── Permission prompt (dismissible banner) ─────────────────────────── */
function showPermissionPrompt() {
    if (localStorage.getItem(DISMISSED_KEY)) return;
    if (document.getElementById(PROMPT_ID)) return;

    const prompt = document.createElement('div');
    prompt.id = PROMPT_ID;
    prompt.innerHTML = `
        <div class="fixed bottom-5 right-5 z-[9999] max-w-sm w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-start gap-3 p-4">
                <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Aktifkan Notifikasi Browser</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        Dapatkan notifikasi real-time untuk peminjaman, buku baru, dan pengingat lainnya.
                    </p>
                </div>
                <button id="${PROMPT_ID}-close" class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-lg leading-none">
                    &times;
                </button>
            </div>
            <div class="flex gap-2 px-4 pb-4">
                <button id="${PROMPT_ID}-allow" class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    Ya, Aktifkan
                </button>
                <button id="${PROMPT_ID}-later" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-xl transition-colors">
                    Nanti Saja
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(prompt);

    function removePrompt() {
        prompt.remove();
    }

    document.getElementById(`${PROMPT_ID}-close`).addEventListener('click', () => {
        localStorage.setItem(DISMISSED_KEY, '1');
        removePrompt();
    });

    document.getElementById(`${PROMPT_ID}-later`).addEventListener('click', () => {
        removePrompt(); // Don't persist dismissal — ask again next session
    });

    document.getElementById(`${PROMPT_ID}-allow`).addEventListener('click', async () => {
        removePrompt();
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            startPolling();
            // Immediately show a welcome notification
            showBrowserNotification({
                id     : 'welcome',
                title  : 'Notifikasi Aktif ✓',
                message: 'Kamu akan mendapatkan notifikasi real-time dari perpustakaan.',
            });
        } else {
            localStorage.setItem(DISMISSED_KEY, '1');
        }
    });
}

/* ─── Start polling loop ──────────────────────────────────────────────── */
function startPolling() {
    pollNotifications(); // First check immediately
    setInterval(pollNotifications, POLL_INTERVAL);
}

/* ─── Entry point ─────────────────────────────────────────────────────── */
function init() {
    if (!supported()) return;

    if (Notification.permission === 'granted') {
        startPolling();
    } else if (Notification.permission === 'default') {
        // Show prompt after a short delay so it doesn't feel intrusive on load
        setTimeout(showPermissionPrompt, 3_000);
    }
    // If 'denied', do nothing — respect the browser setting
}

// Boot when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
