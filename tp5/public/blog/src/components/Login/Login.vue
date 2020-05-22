<template>
  <el-card class="box-card">
    <el-tabs v-model="activeName" @tab-click="handleClick">
      <!-- 登录 -->
      <el-tab-pane label="登录" name="login">
        <el-form ref="loginForm" :model="loginForm" label-width="0px" :rules="loginRules">
          <el-form-item prop="email">
            <el-input v-model="loginForm.email" placeholder="邮箱号" prefix-icon="el-icon-user-solid"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input v-model="loginForm.password" placeholder="密码" prefix-icon="el-icon-key"></el-input>
          </el-form-item>
          <!-- <el-form-item  prop="captcha">
          <el-row>
            <el-col :span="12"
              ><el-input
                v-model="loginForm.captcha"
                placeholder="验证码"
                prefix-icon="el-icon-s-opportunity"
              ></el-input>
            </el-col>
            <el-col :span="12">    <el-image
            style="width: 90%; height: 39px"
            :src="captcha"
            :fit="fit" @click="refresh()"></el-image></el-col>
          </el-row>
          </el-form-item>-->
          <el-form-item>
            <el-button type="primary" @click="login(loginForm)" class="loginBtn">登录</el-button>
          </el-form-item>
        </el-form>
      </el-tab-pane>
      <!-- 注册 -->
      <el-tab-pane label="注册" name="register">
          <el-form ref="registerForm" :model="registerForm" label-width="0px" :rules="registerRules">
          <el-form-item prop="email">
            <el-input v-model="registerForm.email" placeholder="邮箱号" prefix-icon="el-icon-user-solid"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input v-model="registerForm.password" placeholder="密码" prefix-icon="el-icon-key"></el-input>
          </el-form-item>
          <el-form-item prop="repassword">
            <el-input v-model="registerForm.repassword" placeholder="确认密码" prefix-icon="el-icon-key"></el-input>
          </el-form-item>
          <!-- <el-form-item  prop="captcha">
          <el-row>
            <el-col :span="12"
              ><el-input
                v-model="loginForm.captcha"
                placeholder="验证码"
                prefix-icon="el-icon-s-opportunity"
              ></el-input>
            </el-col>
            <el-col :span="12">    <el-image
            style="width: 90%; height: 39px"
            :src="captcha"
            :fit="fit" @click="refresh()"></el-image></el-col>
          </el-row>
          </el-form-item>-->
          <el-form-item>
            <el-button type="primary" @click="login(loginForm)" class="loginBtn">登录</el-button>
          </el-form-item>
        </el-form>
        </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
export default {
  props: {},
  data () {
    //   邮箱正则
    var regemail = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
    // 密码正则
    var regPwd = /^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)(?!([^(0-9a-zA-Z)])+$).{6,20}$/
    // 邮箱验证
    var checkemail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('邮箱不能为空'))
      }
      if (!regemail.test(value)) {
        callback(new Error('请输入正确的邮箱格式'))
      } else {
        return callback()
      }
    }
    // 密码验证
    var checkPwd = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('密码不能为空'))
      }
      if (!regPwd.test(value)) {
        callback(new Error('密码包含 数字,英文,字符中的两种以上，长度6-20'))
      } else {
        return callback()
      }
    }
    // 确认密码验证
    var validatePass2 = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请再次输入密码'))
      } else if (value !== this.registerForm.password) {
        callback(new Error('两次输入密码不一致!'))
      } else {
        callback()
      }
    }
    return {
      // 标签默认选项
      activeName: 'login',
      fit: '', // 为了解决验证码刷新时的fit属性不存在的问题
      // 验证码地址
      captcha: 'http://tp5.com/captcha.html',
      // 登录绑定数据
      loginForm: {
        email: '406322283@qq.com',
        password: 'chen1234',
        captcha: ''
      },
      // 登录验证规则
      loginRules: {
        email: [
          //   { required: true, message: '请输入邮箱账号', trigger: 'blur' },
          { validator: checkemail, trigger: 'blur' }
        ],
        password: [{ validator: checkPwd, trigger: 'blur' }]
        // ],
        // captcha: [
        //   { required: true, message: '验证码不能为空', trigger: 'blur' }
        // ]
      },
      // 注册绑定数据
      registerForm: {
        email: '',
        password: '',
        repassword: ''
      },
      // 注册验证
      registerRules: {
        email: [
          { validator: checkemail, trigger: 'blur' }
        ],
        password: [{ validator: checkPwd, trigger: 'blur' }],
        // ],
        // captcha: [
        //   { required: true, message: '验证码不能为空', trigger: 'blur' }
        // ]
        repassword: [{ validator: validatePass2, trigger: 'blur' }]
      }
    }
  },
  watch: {},
  computed: {},
  methods: {
    // 登录方法
    login (loginForm) {
      this.$refs.loginForm.validate(async valid => {
        if (!valid) return
        const { data: res } = await this.$http.post(
          'index/user/login',
          this.loginForm
        )
        if (res.code === 0) {
          return this.$alert.error('账号或密码错误！')
        } else {
          window.sessionStorage.setItem('token', res.token)
          this.$router.push('/home')
          return this.$alert.success('登陆成功！')
        }
      })
    },
    register (registerForm) {
    }
    // async login (loginForm) {
    //   const { data: res } = await this.$http.post('index/user/login', this.loginForm)
    //   console.log(res)
    // }
    // refresh () {
    //   this.captcha = 'http://tp5.com/captcha.html'
    // }
  },
  created () {},
  mounted () {}
}
</script>
<style scoped>
/* 卡片 */
.box-card {
  width: 20%;
  margin-left: 40%;
  margin-top: 15%;
}
/* 登录按钮 */
.loginBtn {
  width: 100%;
}
</style>
