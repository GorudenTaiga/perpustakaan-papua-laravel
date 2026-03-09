import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        // Warn on chunks over 600KB
        chunkSizeWarningLimit: 600,
        rollupOptions: {
            output: {
                // Split axios (AJAX helper) from main app code
                manualChunks: {
                    vendor: ['axios'],
                },
            },
        },
    },
    plugins: [
        laravel({
            // admin/theme.css is only needed on admin routes, not member pages
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/notifications.js',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
