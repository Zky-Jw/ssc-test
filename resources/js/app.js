import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
// import lottie from 'lottie-web';
import Toast from "vue-toastification";
import { Icon } from '@iconify/vue';
// import { defineElement } from 'lord-icon-element';
import('preline');
import VueApexCharts from "vue3-apexcharts";
import CKEditor from '@ckeditor/ckeditor5-vue';
import helper from "./helper.js";
import VueCryptojs from 'vue-cryptojs'
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import "vue-toastification/dist/index.css";

// defineElement(lottie.loadAnimation);

const toastOptions = {
    transition: "Vue-Toastification__fade",
    maxToasts: 3,
    newestOnTop: true
}

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin, VueApexCharts, CKEditor, VueCryptojs)
            .use(Toast, toastOptions)
            .use(ZiggyVue, Ziggy)
            .use(helper, helper)
            .component('EasyDataTable', Vue3EasyDataTable)
            .component('Icon', Icon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
