import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import MainLayout from './Layout/MainLayout.vue';
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page =  pages[`./Pages/${name}.vue`]
    
    /* EmptyLayout megoldas
    if (page.default.layout == undefined) { // !!!
      page.default.layout = null
    } else {
      page.default.layout = page.default.layout || MainLayout
    }
      */
      

    page.default.layout = page.default.layout || MainLayout


    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(VCalendar, {})
      .mount(el);
  },
});