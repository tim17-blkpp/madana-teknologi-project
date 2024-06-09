import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      redirect: to => {
        if (isAuthenticated()) {
          return { name: 'dashboard' }
        }
        
        return { name: 'login' }
      },
    },
    {
      path: '/dashboard',
      meta: { requiresAuth: true },
      redirect: to => {
        if (isAuthenticated()) {
          return { name: 'dashboard' }
        }
        
        return { name: 'login' }
      },
    },
    {
      path: '/konfigurasi',
      meta: { requiresAuth: true },
      redirect: to => {
        if (isAuthenticated()) {
          return { name: 'konfigurasi' }
        }
        
        return { name: 'login' }
      },
    },
    ...setupLayouts(routes),
  ],
})

function isAuthenticated() {
  const userAbilities = JSON.parse(localStorage.getItem('userAbilities') || '{}')

  const userAction = (userAbilities && userAbilities[0]) ? userAbilities[0].action : null

  return userAction === 'manage'
}


// Docs: https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
export default router
