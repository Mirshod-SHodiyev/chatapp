import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';
import Show from './Show.vue';

window.Alpine = Alpine;
Alpine.start();
const show = createApp(Show);
show.mount('#show');

const authData = JSON.parse(document.getElementById('app').getAttribute('data-auth'));

const app = createApp(App, { auth: authData });

app.mount('#app');
