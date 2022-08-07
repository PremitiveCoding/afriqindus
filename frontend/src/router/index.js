import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home/index.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About/index.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import(/* webpackChunkName: "contact" */ '../views/Contact/index.vue')
  },
  {
    path: '/projects',
    name: 'projects.index',
    component: () => import(/* webpackChunkName: "projects" */ '../views/Projects/index.vue')
  },
  {
    path: '/projects/:slug',
    name: 'projects.show',
    component: () => import(/* webpackChunkName: "projects-detail" */ '../views/Projects/show.vue'),
    props: true,
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
