<template>
  <div id="app">
    <el-card class="box-card">
      <el-form ref="loginForm" :model="loginForm" label-width="0px" :rules="loginRules" >
        <el-form-item  prop="email">
          <el-input v-model="loginForm.email" placeholder="邮箱号" prefix-icon="el-icon-user-solid" ></el-input>
        </el-form-item>
        <el-form-item  prop="password">
          <el-input v-model="loginForm.password" placeholder="密码" prefix-icon="el-icon-key"></el-input>
        </el-form-item>
        <el-form-item  prop="captcha">
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
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="login(loginForm)" class="loginBtn"
            >登录</el-button
          >
        </el-form-item>
      </el-form>
    </el-card>
  </div>
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
      setTimeout(() => {
        if (!regemail.test(value)) {
          callback(new Error('请输入正确的邮箱格式'))
        } else {

        }
      }, 1000)
    }
    // 邮箱验证
    var checkPwd = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('密码不能为空'))
      }
      setTimeout(() => {
        if (!regPwd.test(value)) {
          callback(new Error('密码包含 数字,英文,字符中的两种以上，长度6-20'))
        } else {

        }
      }, 1000)
    }
    return {
      fit: '', // 为了解决验证码刷新时的fit属性不存在的问题
      // 验证码地址
      captcha: 'http://tp5.com/captcha.html',
      loginForm: {
        email: '406322283@qq.com',
        password: 'chen1234',
        captcha: '1111'
      },
      loginRules: {
        email: [
        //   { required: true, message: '请输入邮箱账号', trigger: 'blur' },
          { validator: checkemail, trigger: 'blur' }
        ],
        password: [
          { validator: checkPwd, trigger: 'blur' }
        ],
        captcha: [
          { required: true, message: '验证码不能为空', trigger: 'blur' }
        ]
      }

    }
  },
  watch: {},
  computed: {},
  methods: {
    login (loginForm) {
      const { data: res } = this.$http.post('index/user/login', this.loginForm)
      console.log(res)
    },
    refresh () {
      console.log(this.randomNum)
      this.captcha = 'http://tp5.com/captcha.html?a=' + Math.random()
    }
  },
  created () {
  },
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
