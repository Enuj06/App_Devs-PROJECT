import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import './assets/css/main.css'

loadFonts()
//lumalabas dito
//ayaw sa axios.defaults.baseURL="http://App_Devs-PROJECT-backend.test"
// kaya naman ay lumabas ng data galing database
createApp(App)
  .use(router)
  .use(vuetify)
  .mount('#app')
