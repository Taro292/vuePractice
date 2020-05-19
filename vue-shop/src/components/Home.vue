<template>
<!-- 退出登录 -->
    <el-container class="home-container">
      <!-- 头部区域 -->
      <el-header>Header
        <el-button type="info" size="small" @click="logout">退出登录</el-button>
      </el-header>
      <el-container>
        <!-- 侧边栏区域 -->
        <el-aside :width="istoggle?'64px':'200px'">
          <el-menu default-active="2" class="el-menu-vertical-demo" unique-opened :collapse ="istoggle" :collapse-transition="false" router>
            <!-- 收缩侧边栏 -->
            <div class="istogglebtn">
              <div :class="istoggle ?'el-icon-s-unfold':'el-icon-s-fold'" @click="collape"></div>
            </div>
            <!-- 一级导航栏 -->
            <el-submenu :index="item.id +''" v-for="item in menuList" :key="item.id">
              <!-- 一级导航栏模块 -->
              <template slot="title">
                <i :class="iconobj[item.id]+''"></i>
                <span>{{item.authName}}</span>
              </template>
            <!-- 二级导航栏 -->
              <el-menu-item :index="'/'+secitem.path + ''" v-for="secitem in item.children" :key="secitem.id">
              <!-- 二级导航栏模块 -->
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span>{{secitem.authName}}</span>
                </template>
              </el-menu-item>
            </el-submenu>
          </el-menu>
        </el-aside>
        <!-- 主体区域 -->
        <el-main>
          <!-- 路由占位符 -->
          <router-view></router-view>
        </el-main>
      </el-container>
    </el-container>
</template>
<script>
export default {
  created () {
    this.getmenuList()
  },
  data() {
    return {
      // 遍历后得到的菜单数据
      menuList: [],
      // 一级菜单图标
      iconobj: {
        125: 'el-icon-user',
        103: 'el-icon-setting',
        101: 'el-icon-goods',
        102: 'el-icon-s-shop',
        145: 'el-icon-s-data'
      },
      // 侧边栏切换的变量
      istoggle: false
    }
  },
  methods: {
    // 退出登录
    logout() {
      window.sessionStorage.clear()
      this.$router.push('/login')
    },
    // 获取菜单内容
    async getmenuList() {
      const { data: res } = await this.$http.get('menus')
      console.log(res)
      if (res.meta.status === 200) {
        this.menuList = res.data
      }
    },
    // 伸缩侧边栏
    collape() {
      this.istoggle = !this.istoggle
    }
  }
}
</script>
<style lang="less" scoped>
  // 最外层容器样式
  .home-container{
    height: 100%;
  }
  // 头部样式
  .el-header {
    background-color: #B3C0D1;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  // 侧边样式
  .el-aside {
    background-color: #fff;
  }
  // 主区域样式
  .el-main {
    background-color: #E9EEF3;
    color: #333;
  }
  // 切换按钮
  .istogglebtn{
    height: 25px;
    line-height: 25px;
    text-align: center;
  }
  .el-menu{
    border-right: none;
  }

</style>
