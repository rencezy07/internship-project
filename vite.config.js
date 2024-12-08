import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '192.168.8.109', // Replace with your laptop's local IP
        port: 5173,            // Default Vite port
        hmr: {
            host: '192.168.8.109', // Ensure hot module replacement uses the correct host
        },
    },
});
