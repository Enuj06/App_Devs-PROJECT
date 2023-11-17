import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import axios from 'axios'
import './assets/css/main.css'

axios.defaults.baseURL="http://App_Devs-PROJECT-backend.test"

createApp(App).use(router).mount('#app')
