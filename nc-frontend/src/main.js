import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'

const app = createApp(App);

// Define the global API base URL
app.provide('API_BASE_URL', 'http://guild-manager-backend.test');
// app.provide('API_BASE_URL', 'https://guild-manager-main-wem0ap.laravel.cloud');

app.use(router).mount('#app');