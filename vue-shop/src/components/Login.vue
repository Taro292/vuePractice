<template>
  <div class="login-container">
      <div class="login-box">
        <!-- 头像 -->
        <div class="login-avatar">
          <img src="../assets/logo.png" alt="">
        </div>
        <!-- 登录表单 -->
        <el-form  label-width="0px" class="login-form" :model="loginForm" :rules="loginRules" ref="loginForm">
          <el-form-item label="" prop="username">
            <el-input prefix-icon="el-icon-user" placeholder="请输入账号" v-model="loginForm.username"></el-input>
          </el-form-item>
          <el-form-item label="" prop="password">
            <el-input prefix-icon="el-icon-lock" placeholder="请输入密码" v-model="loginForm.password" type="password"></el-input>
          </el-form-item>
          <el-form-item class="btn">
            <el-button type="primary" @click="login(loginForm)">登录</el-button>
            <el-button type="info" @click="reset">重置</el-button>
          </el-form-item>
        </el-form>

      </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      loginForm: {
        username: 'admin',
        password: '123456'
      },
      loginRules: {
        username: [
          { required: true, message: '请输入账号', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' }
        ]
      }

    }
  },
  methods: {
    login (loginForm) {
      this.$refs.loginForm.validate(async valid => {
        if (!valid) return
        const { data: res } = await this.$http.post('login', loginForm)
        if (res.meta.status === 400) return this.$alert.error('登录失败')
        else if (res.meta.status === 200) {
          this.$alert.success('登陆成功！')
          console.log(res)
          // 把token存在sessionStorage
          window.sessionStorage.setItem('token', res.data.token)
          // 登陆成功后跳转地址，编程式导航
          this.$router.push('/home')
        }
      })
    },
    reset () {
      this.$refs.loginForm.resetFields()
    }
  }
}
</script>

<style lang="less" scoped>
.login-container{
  background: lightblue;
  height: 100%;
}
.login-box{
  height: 250px;
  width:400px;
  background-color: white;
  border-radius:5px;
  position: absolute;
  left: 50%;
  top:50%;
  transform: translate(-50%,-50%);
}
.login-avatar{
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #eee;
  box-shadow: 0 0 10px lightcyan;
  position:absolute;
  left: 50%;
  top: -50px;
  transform: translate(-50%);
}
img{
  height: 100%;
  width: 100%;
  border-radius: 50%;
}
.login-form{
  position: absolute;
  top: 50px;
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
}
.btn{
  display: flex;
  justify-content: flex-end;
}
</style>
