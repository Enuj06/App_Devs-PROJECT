import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import LoginView from '../views/LoginView.vue'
import Communicate from '../views/Communicate.vue'
import Create from '../views/Create.vue'
import Events from '../views/Events.vue'
import FAQs from '../views/FAQs'
import AboutView from '../views/AboutView'
import Header from '../views/admin/Header.vue'
const routes = [
  {
    path: '/',

    component: LoginView
  },
  {
    path: '/login',
    component: IndexPage
  },
  {
    path: '/communicate',
    component: Communicate
  },
  {
    path: '/create',
    component: Create
  },
  {
    path: '/events',
    component: Events
  },
  {
    path: '/FAQs',
    component: FAQs
  },
  {
    path: '/about',
    component: AboutView
  },
  {
    path: '/admin',
    component: Header
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
