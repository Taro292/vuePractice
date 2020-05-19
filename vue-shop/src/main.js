import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './plugins/element.js'
import './assets/css/global.css'
import axios from 'axios'

// 请求根路径
axios.defaults.baseURL = 'http://106.12.11.162:8888/api/private/v1/'
// axios.headers.access_token = localStorage.getItem('token')
// 挂载到原型上，可以直接this使用

Vue.prototype.$http = axios
Vue.config.productionTip = false
axios.interceptors.request.use(config => {
  config.headers.Authorization = window.sessionStorage.getItem('token')
  return config
})
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
