import { createRouter, createWebHashHistory } from 'vue-router'
import { useAppStore } from './stores/app-store'
import { resolveNavigation } from './navigation'
import Dashboard from './pages/home/home.vue'
import Connections from './pages/connections/connections.vue'
import SupportDebug from './pages/support-debug/support-debug.vue'

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
  },
  {
    path: '/connections',
    name: 'connections',
    component: Connections,
  },
  {
    path: '/support-debug',
    name: 'supportDebug',
    component: SupportDebug,
  },
]

export const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

// The rules themselves live in `navigation.js`, free of Vue and Pinia imports so
// they can be unit-tested.
router.beforeEach((to) => resolveNavigation(to, useAppStore()))
