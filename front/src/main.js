import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from '@/utils/axios';

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
  created() {
    // axios.get('/user')
    axios.get('/sanctum/csrf-cookie').then(response => {
      console.log(response)
    });
  }
}).$mount('#app')
