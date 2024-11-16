// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.css';

// Import jQuery dan Bootstrap JS
import 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

const app = createApp(App);
const pinia = createPinia();

app.use(VueSidebarMenu)
app.use(pinia);
app.use(router);
app.mount('#app');
