import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/resultados-socket.js', // 👈 NUEVO ENTRYPOINT
                'resources/js/votar-socket.js',      // 👈 NUEVO ENTRYPOINT
                'resources/js/welcome-socket.js',    // 👈 NUEVO ENTRYPOINT
            ],
            refresh: true,
        }),
    ],
});
