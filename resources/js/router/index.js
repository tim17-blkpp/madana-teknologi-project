import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      redirect: to => {
        const userAbilities = JSON.parse(localStorage.getItem('userAbilities') || '{}')
        const userAction = (userAbilities && userAbilities[0].action) ? userAbilities[0].action : null

        if (userAction === 'manage') { // langsung masuk ke dashboard
          return { name: 'dashboard' }
        }
        else {
          console.warn("NOT AUTHORIZED")
        }
        
        return { name: 'login' }
      },
    },
    {
      
    },
    ...setupLayouts(routes),
  ],
})


// Docs: https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
export default router
