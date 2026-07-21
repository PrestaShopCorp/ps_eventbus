import { createRouter, createWebHashHistory } from 'vue-router'
import Home from './pages/home/home.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
]

export const router = createRouter({
  history: createWebHashHistory(),
  routes,
})
