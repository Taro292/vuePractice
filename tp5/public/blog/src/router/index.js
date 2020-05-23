import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../components/Home/Home.vue'
import Index from '../components/Index/Index'
Vue.use(VueRouter)

const routes = [
  {
    path: '/home',
    name: 'Home',
    component: Home,
    children: [
      { path: '/index', name: 'Index', component: Index }
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../components/Login/Login')
  }
]

const router = new VueRouter({
  routes
})
// 挂载路由导航守卫
router.beforeEach((to, from, next) => {
  // to：是去哪里
  // from：是从哪里来
  // next：是放行可以加参数，比如next（'/login'）放行到login组件

  // 如果是从login组件过来的就放行
  if (to.path === '/login') return next()
  // 得到本地的token
  const token = window.sessionStorage.getItem('token')
  // 如果token不存在就强制放行到login组件
  if (!token) return next('/login')
  // 否则就放行
  next()
})
/**
 * 重写路由的push方法
 */
// const routerPush = VueRouter.prototype.push
// VueRouter.prototype.push = function push (location) {
//   return routerPush.call(this, location).catch(error => error)
// }

export default router
