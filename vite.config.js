import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: 'localhost', // servidor vite
        port: 5173,        // puerto vite
        hmr: {
            host: 'instagram.com.devel', // 👈 tu dominio local
        },
    },
});
