require('./bootstrap');

import { createApp, h } from 'vue';
import { createPinia } from 'pinia'
import VCalendar from 'v-calendar';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import piniaPersist from 'pinia-plugin-persist'
import 'maz-ui/css/main.css';
import 'v-calendar/dist/style.css';
// import 'flowbite';


const pinia = createPinia()
pinia.use(piniaPersist)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(pinia)
            .use(VCalendar, {})
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({
  color: '#4B5563' ,
});

//9605639438
