import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
       	sourcemap: false,
	minify: false
    },
    plugins: [
        laravel({
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
