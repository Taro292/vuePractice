import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../components/Login.vue'
import Home from '../components/Home.vue'
import Welcome from '../components/Welcome.vue'
import Categories from '../components/Categories.vue'
import Goods from '../components/Goods.vue'
import Orders from '../components/Orders.vue'
import Params from '../components/Params.vue'
import Reports from '../components/Reports.vue'
import Rights from '../components/Rights.vue'
import Roles from '../components/Roles.vue'
import Users from '../components/Users.vue'
Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    { path: '/', redirect: '/login' },
    { path: '/login', component: Login },
    {
      path: '/home',
      component: Home,
      redirect: '/welcome',
      children: [
        {
          path: '/welcome',
          component: Welcome
        },
        {
          path: '/categories',
          component: Categories
        },
        {
          path: '/goods',
          component: Goods
        },
        {
          path: '/orders',
          component: Orders
        },
        {
          path: '/params',
          component: Params
        },
        {
          path: '/reports',
          component: Reports
        },
        {
          path: '/rights',
          component: Rights
        },
        {
          path: '/roles',
          component: Roles
        },
        {
          path: '/users',
          component: Users
        }
      ]
    }
  ]
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
export default router
