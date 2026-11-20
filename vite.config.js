
import { defineConfig } from 'vite';

// Laravel Vite plugin connects frontend files to Laravel Blade pages.
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/style.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
