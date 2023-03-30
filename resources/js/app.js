import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from "ziggy-js/dist/vue";
import ElementPlus from "element-plus";
import 'element-plus/dist/index.css'
import { InertiaProgress } from '@inertiajs/progress'
import vi from "element-plus/es/locale/lang/vi";
import 'bootstrap/dist/css/bootstrap-grid.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.js '
import "bootstrap-icons/font/bootstrap-icons.css";
import CKEditor from '@ckeditor/ckeditor5-vue';

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Quản lý báo";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(ElementPlus, { locale: vi})
        .mixin({ methods: { route } })
        .use(CKEditor)
        .mount(el)
  },
})

InertiaProgress.init({ color: "#4B5563" })