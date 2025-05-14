import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/styles.scss', // এই লাইন যোগ করুন
                'resources/js/app.js',
            ],
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
    build: {
        // চাঙ্ক সাইজ ওয়ার্নিং লিমিট বাড়ানো (কিলোবাইটে)
        chunkSizeWarningLimit: 1000,

        rollupOptions: {
            output: {
                // লাইব্রেরি অনুযায়ী ম্যানুয়াল চাঙ্কিং
                manualChunks: {
                    'vendor': [
                        'vue',
                        '@inertiajs/vue3',
                        'axios'
                    ],
                    'primevue': [
                        'primevue',
                        'primevue/button',
                        'primevue/datatable',
                        'primevue/column',
                        'primevue/dialog',
                        'primevue/toast',
                        'primevue/toastservice',
                        'primevue/inputtext',
                        'primevue/splitbutton',
                        'primevue/tag'
                    ],

                }
            }
        }
    },
    // অপ্টিমাইজেশন অপশন
    optimizeDeps: {
        include: ['vue', '@inertiajs/vue3', 'primevue']
    },
    // সার্ভার কনফিগারেশন
    server: {
        hmr: {
            host: 'localhost'
        }
    }
});
