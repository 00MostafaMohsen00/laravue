import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ZiggyVue } from 'ziggy';
import { InertiaProgress } from '@inertiajs/progress';
import '../css/app.css';
import { createI18n } from 'vue-i18n';
import store from './store';
import 'vue-toast-notification/dist/theme-sugar.css';
import Vue3Lottie from 'vue3-lottie';
import '@fortawesome/fontawesome-free/css/all.css';


InertiaProgress.init({
    delay: 0,
    color: '#4B5563',
    includeCSS: true,
    showSpinner: true,
});



createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue');
        const page = (await pages[`./Pages/${name}.vue`]());
        if(name.split('/')[0] == 'Admin'){
             page.default.layout = page.default.layout || AdminLayout;
        }else{
            page.default.layout = page.default.layout || MainLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        const messages = {
            en: import('../../lang/en.json'),
            ar: import('../../lang/ar.json')
        };

        Promise.all([messages.en, messages.ar]).then((results) => {
            const i18n = createI18n({
                legacy: false,
                locale: props.initialPage.props.local_code,
                fallbackLocale: 'en',
                messages: {
                    en: results[0].default,
                    ar: results[1].default,
                },
            });

            const app = createApp({ render: () => h(App, props) });
            app.use(plugin)
                .use(ZiggyVue)
                .use(i18n)
                .use(store)
                .use(Vue3Lottie)
                .mount(el);

            // Set the direction based on the locale
            document.documentElement.dir = props.initialPage.props.local_dir;
            store.dispatch("loadLastSearch");
            store.dispatch("loadisSearchActive");
        });
    },
});
