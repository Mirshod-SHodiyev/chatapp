import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';

window.Alpine = Alpine;
Alpine.start();

// Get authenticated user data from a global variable or server-side rendering
const authData = JSON.parse(document.getElementById('app').getAttribute('data-auth'));

const app = createApp(App, { auth: authData }); // Pass the auth prop
app.mount('#app');
