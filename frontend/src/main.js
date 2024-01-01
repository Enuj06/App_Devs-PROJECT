import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
//import '@/assets/css/main.css'
import axios from 'axios'
import './assets/css1/logo.css';


loadFonts()
//lumalabas dito
//ayaw sa 
axios.defaults.baseURL="http://localhost:8080/"
// kaya naman ay lumabas ng data galing database
createApp(App)
  .use(router)
  .use(vuetify)
  .mount('#app')
