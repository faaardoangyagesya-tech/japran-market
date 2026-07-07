import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../pages/Home.vue'),
  },
  {
    path: '/stock',
    name: 'Stock',
    component: () => import('../pages/Stock.vue'),
  },
  {
    path: '/stock/:slug',
    name: 'GameDetail',
    component: () => import('../pages/GameDetail.vue'),
  },
  {
    path: '/stock/:slug/:id',
    name: 'AccountDetail',
    component: () => import('../pages/AccountDetail.vue'),
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../pages/About.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

export default router
