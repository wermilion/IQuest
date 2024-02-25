import './assets/scss/global.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './app.vue'
import router from './router'
import { initCustomDirectives } from '#/derectives'

const pinia = createPinia()
const app = createApp(App)
initCustomDirectives(app)

app.use(router)
app.use(pinia)

router.isReady().then(() => app.mount('#app'))
