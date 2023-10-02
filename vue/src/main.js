import { createApp } from 'vue'
import store from './store'
import router from './router'
import './index.css'
import App from './App.vue'

createApp(App) //creat new root Vue instance used to be mount the app to a DOM element in the html docs
    .use(store)
    .use(router)
    .mount('#app')
