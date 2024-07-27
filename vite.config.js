import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/gondes.css',
                'resources/css/tabler.min.css',
                'resources/css/tabler-payments.min.css',
                'resources/css/tabler-vendors.min.css',
                'resources/css/demo.min.css',
                'resources/css/tabler-icons.min.css',
                'resources/css/select2.min.css',
                'resources/css/select2-bootstrap5.min.css',
                'resources/css/select2-bootstrap5-rtl.min.css',
                'resources/js/jquery.min.js',
                'resources/js/app.js',
                'resources/js/serialize-object.js',
                'resources/js/tabler.min.js',
                'resources/js/demo-theme.min.js',
                'resources/js/demo.min.js',
            ],
            refresh: true,
        }),
    ],
});
