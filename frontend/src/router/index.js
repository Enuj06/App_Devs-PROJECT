import { createRouter, createWebHistory } from 'vue-router'
import IndexPage from '../views/IndexPage.vue'
import LoginView from '../views/LoginView.vue'
import Communicate from '../views/Communicate.vue'
import Create from '../views/Create.vue'
import Events from '../views/Events.vue'
import FAQs from '../views/FAQs'
import Appointments from '../views/Appointments.vue'
import AboutView from '../views/AboutView'
import Header from '../views/admin/Header.vue'
import Adminhomepage from '../views/Adminhomepage.vue'
import AddFaq from '../views/admin/AddFaq.vue'
import Users from '../views/Users.vue'
import Announcements from '../views/Announcements.vue'
import FaqsAdmin from '../views/FaqsAdmin.vue'
import Schedules from '../views/Schedules.vue'
import Counselor from '../views/Counselor.vue'
import Feedback from '../views/Feedback.vue'
import AdminFeedback from '../views/AdminFeedback.vue'

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
    path: '/appointments',
    component: Appointments
  },

  {
    path: '/about',
    component: AboutView
  },
  {
    path: '/admin',
    component: Header
  },
  {
    path: '/adminhome',
    component: Adminhomepage
  },
  {
    path: '/addFaq',
    component: AddFaq
  },
  {
    path: '/users',
    component: Users
  },
  {
    path: '/announcements',
    component: Announcements
  },
  {
    path: '/faqsadmin/:id?',
    component: FaqsAdmin,
    name: 'FAQ'
  },
  
  {
    path: '/schedules/:id?',
    component: Schedules,
    name: 'sched'
  },
  {
    path: '/counselor',
    component: Counselor
  },
  {
    path:'/cfeedback',
    component: Feedback,
  },
  {
    path: '/adminfeedback',
    component: AdminFeedback,
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
