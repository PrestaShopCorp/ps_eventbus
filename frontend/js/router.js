import { createRouter, createWebHashHistory } from 'vue-router'
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
