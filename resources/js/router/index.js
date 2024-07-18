import { createRouter, createWebHistory } from 'vue-router';
import { setupLayouts } from 'virtual:generated-layouts';
import routes from '~pages';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: () => ({ name: 'madana' }),
    },
    {
      path: '/login',
      redirect: () => (isAuthenticated() ? { name: 'dashboard' } : { name: 'login' }),
    },
    {
      path: '/dashboard',
      meta: { requiresAuth: true },
      redirect: () => (isAuthenticated() ? { name: 'dashboard' } : { name: 'login' }),
    },
    {
      path: '/konfigurasi',
      meta: { requiresAuth: true },
      redirect: () => (isAuthenticated() ? { name: 'konfigurasi' } : { name: 'login' }),
    },
    ...setupLayouts(routes),
  ],
});

function isAuthenticated() {
  const token = localStorage.getItem('accessToken');
  return token !== null;
}

export default router;
