import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,

            /** 👇 Esta es la parte importante */
            // devServer: {
            //     https: false,
            //     host: '192.168.1.72',
            //     port: 5173,
            // }
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
    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     https: false,
    //     hmr: {
    //         host: '192.168.1.72',
    //     },
    // },
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/js'),
        }
    },
});
