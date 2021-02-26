require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import CKEditor from '@ckeditor/ckeditor5-vue';
import moment from "moment";

const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .mixin({
        methods: {
            formatDate(value) {
                return moment(value).format("D MMM, Y");
            },
        }
    })
    .use(InertiaPlugin)
    .use(CKEditor)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
