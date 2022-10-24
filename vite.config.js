import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/backend/css/main.css',
                'resources/backend/css/font-awesome/4.7.0/css/font-awesome.min.css',
                'resources/backend/js/jquery-3.2.1.min.js',
                'resources/backend/js/popper.min.js',
                'resources/backend/js/bootstrap.min.js',
                'resources/backend/js/main.js',
                'resources/backend/js/plugins/pace.min.js',
            ],
            refresh: true,
        }),
    ],
});
