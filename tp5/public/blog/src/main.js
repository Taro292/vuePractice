import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './plugins/element.js'
import axios from 'axios'

// 请求根路径
axios.defaults.baseURL = 'http://tp5.com/'
// axios.headers.access_token = localStorage.getItem('token')
// 挂载到原型上，可以直接this使用

Vue.prototype.$http = axios
Vue.config.productionTip = false
axios.interceptors.request.use(config => {
  config.headers.Authorization = window.sessionStorage.getItem('token')
  return config
})
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
