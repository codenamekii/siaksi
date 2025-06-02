import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/filament/gjm/theme.css',
        'resources/css/filament/ujm/theme.css',
      ],
      refresh: true,
    }),
  ],
});