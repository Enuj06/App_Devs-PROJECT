import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import LoginView from '../views/LoginView.vue'
import Communicate from '../views/Communicate.vue'


const routes = [
  {
    path: '/',

    component: IndexPage
  },
  {
    path: '/login',
    component: LoginView  
  },
  {
    path: '/communicate',
    component: Communicate
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
