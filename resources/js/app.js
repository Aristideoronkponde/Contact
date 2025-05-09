import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast, { useToast } from 'vue-toastification';  // Import des fonctions nécessaires de vue-toastification
import 'vue-toastification/dist/index.css';  // Import des styles CSS de vue-toastification

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Utilisation du plugin vue-toastification
        app.use(plugin);
        app.use(ZiggyVue);
        app.use(Toast);  // Ajout de Toast au niveau de l'application Vue

        app.mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});



