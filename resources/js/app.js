import '../css/app.css';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toaster from "@meforma/vue-toaster";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';
import Card from 'primevue/card';
import Avatar from 'primevue/avatar';
import Fieldset from 'primevue/fieldset';
import SplitButton from 'primevue/splitbutton';

import 'primeicons/primeicons.css';

const appName = import.meta.env.VITE_APP_NAME || 'WEMS';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin)
        .use(ZiggyVue)
        .use(Toaster)
        .use(Toast, {
            transition: "Vue-Toastification__bounce",
            maxToasts: 20,
            newestOnTop: true
        })
        .use(ToastService)
        .use(ConfirmationService)
        .directive('tooltip', Tooltip)
        .component('Card', Card)
        .component('Avatar', Avatar)
        .component('Fieldset', Fieldset)
        .component('SplitButton', SplitButton)
        .use(PrimeVue, {
            theme: {
                preset: Aura
            }
        })
        .mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
