import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import viteCompression from 'vite-plugin-compression';
import { ViteMinifyPlugin } from 'vite-plugin-minify'

export default defineConfig({
    plugins: [
        viteCompression({
            verbose: true,
        }),
        ViteMinifyPlugin({}),
        laravel({
            input: [
                'resources/js/app.jsx',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        react(),
    ],
    build: {
        chunkSizeWarningLimit: 1600,
    },
});
