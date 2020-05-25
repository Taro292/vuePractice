<template>
  <el-row :gutter="20">
  <el-col :span="12" :offset="6">
    <el-card>
        <el-container>
            <!-- 头部区域 -->
            <el-header>
                <el-row>
                    <!-- 左侧用户信息 -->
                    <el-col :span="12">
                        <el-row>
                            <el-col :span="6">
                                <el-avatar shape="square" :size="50" :src="articleContainer.avatar"></el-avatar>
                            </el-col>
                            <el-col :span="18">
                                {{articleContainer.author}}
                            </el-col>
                        </el-row>
                    </el-col>
                    <!-- 右侧操作区域 -->
                    <el-col :span="12" style="border: 1px solid black"></el-col>
                </el-row>
            </el-header>
            <el-card>
                <el-tag closable>标签占位
                </el-tag>
            </el-card>
            <el-main>{{articleContainer.content}}{{articleContainer.imgs}}</el-main>
        </el-container>

    </el-card>
  </el-col>
</el-row>
</template>

<script>
export default {
  props: {},
  data () {
    return {
      articleContainer: {
        author: '',
        avatar: '',
        title: '',
        content: '',
        imgs: '',
        tags: ''
      }
    }
  },
  watch: {},
  computed: {},
  methods: {
    async getArticleContainer () {
      const articleId = JSON.parse(this.$route.params.id)
      console.log(articleId)
      const { data: res } = await this.$http.post('index/article/searchArticle', { id: articleId })
      if (res.code === 1) {
        this.articleContainer = res.data
      }
    }
  },
  created () {
    this.getArticleContainer()
  },
  mounted () {}
}
</script>
<style scoped>
</style>
