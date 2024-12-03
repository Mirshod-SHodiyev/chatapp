import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';
import App from './App.vue';
import Profile from './components/Profile.vue';

window.Alpine = Alpine;
Alpine.start();


const appElement = document.getElementById('app');
if (appElement) {
    const authData = JSON.parse(appElement.getAttribute('data-auth'));
    const app = createApp(App, { auth: authData });
    app.mount('#app');
}

const profileElement = document.getElementById('profile');
if (profileElement) {
    const authProfile = JSON.parse(profileElement.getAttribute('data-auth'));
    const profile = createApp(Profile, { auth: authProfile });
    profile.mount('#profile');
}
