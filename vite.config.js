import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                base: null,
                includeAbsolute: false,
            },
        }),
    ],
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/index.esm.js'),
        },
    },
    server: {
        host: '0.0.0.0',
        port: 3000,
        strictPort: true,
        hmr: {
            protocol: 'ws',
            host: '192.168.1.8',
        },
        headers: {
            'Access-Control-Allow-Origin': '*', // Allow CORS
        },
        watch: {
            usePolling: true,
        },
    }
});
