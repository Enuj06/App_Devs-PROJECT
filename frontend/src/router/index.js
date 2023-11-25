import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import LoginView from '../views/LoginView.vue'
import Communicate from '../views/Communicate.vue'
import Create from '../views/Create.vue'



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
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
