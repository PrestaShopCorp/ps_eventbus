import { createRouter, createWebHashHistory } from 'vue-router'
import { useAppStore } from './stores/app-store'
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

router.beforeEach((to) => {
  const appStore = useAppStore()

  // `&debug=1` on the admin URL sends the merchant straight to Support & debug,
  // whatever route the hash asked for. Only on the first navigation: the tab is
  // unlocked from then on, and must stay navigable away from.
  if (appStore.consumeSupportDebugRedirect() && to.name !== 'supportDebug') {
    return { name: 'supportDebug', query: { debug: '1' } }
  }

  // The tab is already disabled, but the hash URL can still be typed by hand.
  if (to.name === 'connections') {
    return appStore.connectionsAvailable ? true : { name: 'dashboard' }
  }

  // Support & debug has no tab until it is unlocked. `?debug=1` in the hash
  // works too, and is deliberately left in the URL so it stays copyable.
  if (to.name === 'supportDebug') {
    if (to.query.debug === '1') appStore.unlockSupportDebug()

    return appStore.supportDebugUnlocked ? true : { name: 'dashboard' }
  }

  return true
})
