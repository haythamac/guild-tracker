import { createRouter, createWebHistory } from 'vue-router';
import Players from '../views/Players.vue';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';

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
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('token')) {
        next('/');
      } else {
        next();
      }
    }
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL || ''),
  routes
});

router.beforeEach((to, from, next) => {
  if (to.path !== '/' && to.path !== '/login' && !localStorage.getItem('token')) {
    next('/login');
  } else {
    next();
  }
});

export default router;