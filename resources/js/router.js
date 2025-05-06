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
        // Catch all route - must be last
        path: '/:pathMatch(.*)*',
        redirect: '/dashboard'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Check if user is authenticated
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

// 👇 Setup global navigation guard
router.beforeEach(async (to, from, next) => {
    // Get current auth state from backend
    try {
      const res = await axios.get('/api/user') // Sanctum will return user if authenticated
      const isAuthenticated = !!res.data
  
      if (to.meta.requiresAuth && !isAuthenticated) {
        return next('/login') // Not logged in → redirect to login
      }
  
      if (to.meta.requiresGuest && isAuthenticated) {
        return next('/dashboard') // Already logged in → redirect from login
      }
  
      return next()
    } catch (error) {
      // Not authenticated or /api/user failed
      if (to.meta.requiresAuth) {
        return next('/login')
      }
  
      return next()
    }
})

export default router; 