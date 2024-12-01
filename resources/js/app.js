import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';

window.Alpine = Alpine;
Alpine.start();


const authData = JSON.parse(document.getElementById('app').getAttribute('data-auth'));

const app = createApp(App, { auth: authData });

app.mount('#app');
