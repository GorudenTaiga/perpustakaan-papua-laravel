/**
 * Service Worker for Web Push Notifications
 * This file runs in the background even when the website is closed.
 * It receives push events from the server and shows browser notifications.
 */

const NOTIF_URL = '/notifications';

// ─── Push event: fired when server sends a push message ───────────────
self.addEventListener('push', (event) => {
    let data = {};

    try {
        data = event.data ? event.data.json() : {};
    } catch (_) {
        data = { title: 'Notifikasi Baru', body: event.data?.text() || '' };
    }

    const title   = data.title  || 'Perpustakaan';
    const options = {
        body   : data.body   || data.message || '',
        icon   : data.icon   || '/favicon_io/apple-touch-icon.png',
        badge  : data.badge  || '/favicon_io/apple-touch-icon.png',
        tag    : data.tag    || 'perpus-push',
        data   : { url: data.url || NOTIF_URL },
        requireInteraction: false,
    };

    event.waitUntil(
        self.registration.showNotification(title, options).then(() => {
            // Tell all open tabs to refresh their badge counter
            return clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
                clientList.forEach(client => client.postMessage({ type: 'NEW_NOTIFICATION' }));
            });
        })
    );
});

// ─── Notification click: open the notifications page ──────────────────
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const targetUrl = event.notification.data?.url || NOTIF_URL;

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            // If a window with the site is already open, focus it and navigate
            for (const client of clientList) {
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.focus();
                    return client.navigate(targetUrl);
                }
            }
            // Otherwise open a new tab
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});

// ─── Activate: claim clients immediately ──────────────────────────────
self.addEventListener('activate', (event) => {
    event.waitUntil(clients.claim());
});
