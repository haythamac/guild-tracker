import { createRouter, createWebHistory } from 'vue-router';
import Players from '../views/Players.vue';
import Home from '../views/Home.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/players',
    name: 'Players',
    component: Players
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL || ''),
  routes
});

export default router;