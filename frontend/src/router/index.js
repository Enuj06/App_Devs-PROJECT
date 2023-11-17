import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import LoginView from '../views/LoginView.vue'


const routes = [
  {
    path: '/',

    component: IndexPage
  },
  {
    path: '/login',
    component: LoginView  
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
