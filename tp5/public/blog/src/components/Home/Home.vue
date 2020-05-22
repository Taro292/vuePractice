<template>
<el-container class="homeCotainer">
<el-header>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" router>
    <el-menu-item index="1">
        <el-button type="primary" plain @click="logOut()">退出登录</el-button>
    </el-menu-item>
    <el-menu-item index="2">2</el-menu-item>
    <el-menu-item index="3">3</el-menu-item>
    <el-menu-item index="4">4</el-menu-item>
    <el-menu-item index="5">
    </el-menu-item>
    </el-menu>
</el-header>
  <el-main>Main</el-main>
  <el-footer>Footer</el-footer>
</el-container>
</template>

<script>
export default {
  props: {},
  data () {
    return {
      activeIndex: '1'
    }
  },
  watch: {},
  computed: {},
  methods: {
    handleSelect (key, keypath) {
      console.log(key, keypath)
    },
    logOut () {
      window.sessionStorage.clear()
      this.$alert.success('已退出')
    }
  },
  created () {},
  mounted () {}
}
</script>
<style  scoped>
.el-menu--horizontal>.el-menu-item{
  float: right;
}
.el-header, .el-footer {
    background-color: #B3C0D1;
    color: #333;
    text-align: center;
    line-height: 60px;
  }
.el-main {
    background-color: #E9EEF3;
    color: #333;
    text-align: center;
    line-height: 160px;
  }
  .homeCotainer{
      height: 100%;
  }
</style>
