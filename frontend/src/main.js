import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

// Bootstrap CSS & JS
import '../node_modules/bootstrap/dist/css/bootstrap.css'
import '../node_modules/bootstrap/dist/js/bootstrap'





createApp(App)
  .use(router)
  .use(store)
  .mount('#app');
