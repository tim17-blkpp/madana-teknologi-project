import { createApp } from 'vue'
import ComponentNavbar from './components/landing/ComponentNavbar.vue'

const app = createApp({})
app.CompositionEvent('component-navbar', ComponentNavbar)
app.mount('#app')
