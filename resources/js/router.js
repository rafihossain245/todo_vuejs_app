import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Dashboard from './components/Dashboard.vue';

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresGuest: true }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/dashboard'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const checkAuth = async () => {
    try {
        const response = await fetch('/api/user', {
            credentials: 'include',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        return response.ok;
    } catch (error) {
        return false;
    }
};

router.beforeEach(async (to, from, next) => {
    try {
      const res = await axios.get('/api/user')
      const isAuthenticated = !!res.data
  
      if (to.meta.requiresAuth && !isAuthenticated) {
        return next('/login')
      }
  
      if (to.meta.requiresGuest && isAuthenticated) {
        return next('/dashboard')
      }
  
      return next()
    } catch (error) {
      if (to.meta.requiresAuth) {
        return next('/login')
      }
  
      return next()
    }
})

export default router; 