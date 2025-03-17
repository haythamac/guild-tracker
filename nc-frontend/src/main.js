import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'

const app = createApp(App);

// Define the global API base URL
app.provide('API_BASE_URL', 'http://nc-backend.test');

app.use(router).mount('#app');