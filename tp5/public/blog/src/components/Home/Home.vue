<template>
<el-container class="homeCotainer">
  <!-- 头部 -->
  <el-header>
    <!-- 头部菜单 -->
    <el-menu :default-active="activeIndex" class="headerMenu" mode="horizontal" @select="handleSelect" router>
    <!-- 首页 -->
    <el-menu-item index="">首页</el-menu-item>
    <!-- 发现页 -->
    <el-menu-item index="explore">发现</el-menu-item>
    <!-- 等你来答页 -->
    <el-menu-item index="question/waiting">等你来答</el-menu-item>
    <!-- 搜索输入框 -->
    <el-input placeholder="请输入内容"  class="search">
        <el-button slot="append" icon="el-icon-search"></el-button>
    </el-input>
    <el-dropdown  placement="bottom">
        <div class="el-dropdown-link">
            <el-image
            style="width:30px; height:30px;margin:0 10px;"
            :src="this.avatar"
            >
            </el-image>
        </div>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>我的主页</el-dropdown-item>
            <el-dropdown-item>
                <el-button type="primary" plain @click="logOut()">退出登录</el-button>
            </el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
    </el-menu>
  </el-header>
  <!-- 主体内容 -->
  <el-main>
    <el-row type="flex" class="row-bg" justify="center">
        <!-- 文章列表 -->
        <el-col :span="9">
            <el-card class="article">
              <ul id="article-list">
                <li v-for="(item ,index) in article" :key="index">
                <el-container>
                  <el-header>{{index}}</el-header>
                  <el-main>{{item}}</el-main>
                  <el-footer>Footer</el-footer>
                </el-container>
                </li>
              </ul>
            </el-card>
        </el-col>
        <el-col :span="3">
            <el-card>
            </el-card>
        </el-col>

    </el-row>
  </el-main>
  <!-- 底部信息 -->
  <el-footer>Footer</el-footer>
</el-container>
</template>

<script>
export default {
  props: {},
  data () {
    return {
      // 文章数据
      article: [],
      // 文章列表数据
      articleListItem: {
        id: '', // 文章id
        title: '', // 文章标题
        author: '', // 文章作者
        abstract: '', // 文章摘要
        imgs: [], // 文章图片
        tags: '', // 文章标签
        user_id: '' // 用户id
      },
      avatar: '', // 头部头像
      activeIndex: '' // 导航栏默认选择
    }
  },
  watch: {},
  computed: {},
  methods: {
    // 导航栏选中监听
    handleSelect (key, keypath) {
      console.log(key, keypath)
    },
    // 退出登录
    logOut () {
      window.sessionStorage.clear()
      this.$alert.success('已退出')
      this.$router.push('/login')
    },
    // 获取文章列表
    async getArticle () {
      const { data: res } = await this.$http.post('index/article/getArticleList')
      for (var i = 0; i < res.msg.length; i++) {
        console.log(res.msg[i])
      }
      this.article = res.msg
      console.log(this.article)
    }
  },
  created () {
    const data = window.sessionStorage.getItem('userInfo') // 获取已登录的用户信息
    const avatar = data.avatar
    this.avatar = avatar
    this.getArticle()
  },
  mounted () {}
}
</script>
<style  scoped>
/* 头部/底部样式 */
.el-header, .el-footer {
    background-color: #fff;
    color: #333;
    line-height: 60px;
  }
/* 主要区域样式 */
.el-main {
    background-color: WhiteSmoke;
    color: #333;
    text-align: center;
    line-height: 160px;
  }
/* 布局容器样式 */
.homeCotainer{
    height: 100%;
  }
/* 头部菜单栏 */
.headerMenu{
    margin-left: 25%;
}
/* 头部搜索框 */
.search{
    width: 230px!important;
}
::v-deep .el-input__inner{
    width: 100%;
}
/* 文章列表容器 */
.article{
    margin-right: 5px;
}
</style>
