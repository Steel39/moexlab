import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        }
    },
    proxy: {
        '/': {
            target: 'http://localhost:5174', // Укажите адрес вашего сервера
            changeOrigin: true,
            rewrite: (path) => path.replace(/^\/api/, ''), // Измените путь, если необходимо
        },
    },
});
