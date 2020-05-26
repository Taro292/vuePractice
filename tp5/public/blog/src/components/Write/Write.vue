<template>
  <div id="app">
    <el-row :gutter="22">
        <el-col :span="10" :offset="7">
          <el-form ref="addArticleData" :model="addArticleData" label-width="">
            <el-form-item label="">
                <el-input v-model="addArticleData.title" placeholder="标题"></el-input>
            </el-form-item>
            <el-form-item label="" style="display:none;">
                <el-input v-model="addArticleData.user_id" placeholder="用户ID"></el-input>
            </el-form-item>
            <el-form-item label="" style="display:none;">
                <el-input v-model="addArticleData.author" placeholder="作者"></el-input>
            </el-form-item>
            <el-form-item label="" style="display:none;">
                <el-input v-model="addArticleData.author" placeholder="作者"></el-input>
            </el-form-item>
          </el-form>
          <div>
            <editor-bar v-model="addArticleData.content" :isClear="isClear" @change="change"></editor-bar>
          </div>
          <div class="tagsContainer">
            <ul v-for="item in allTags" :key="item.tagname" class="tagsList">
                <li>
                    <el-tag @click="addTags(item.id)" class="tagsItem">{{item.tagname}}</el-tag>
                </li>
            </ul>
          </div>
          <div style="text-align:center;margin-top:5px;">
            <el-button type="success" style="width:50%;" @click="addArticle()">发布</el-button>
          </div>
        </el-col>
    </el-row>
  </div>
</template>

<script>
import EditorBar from '../WangEditor/wangeditor'
export default {
  components: { EditorBar },
  props: {},
  data () {
    return {
      isClear: false, // 清除文本域内容
      addArticleData: {
        title: '', // 标题
        user_id: '', // 用户id
        author: '', // 文章作者
        content: '', // 文章内容
        imgs: '', // 图片
        tags: [] // 标签
      },
      allTags: {
        tagname: ''
      }
    }
  },
  watch: {},
  computed: {},
  methods: {
    // 文章添加标签
    addTags (id) {
      this.addArticleData.tags.push(id)
      this.$alert.success('添加标签成功')
    },
    // 获取所有标签
    async getAllTags () {
      const { data: res } = await this.$http.post('index/tags/gettag')
      if (res.code === 0) return this.$alert.error(res.msg)
      if (res.code === 1) {
        this.allTags = res.data
        return this.$alert.success(res.msg)
      }
    },
    // 获取编辑器内变化时的内容
    change (val) {
      console.log(val)
    },
    // 获取本地用户信息
    getUserInfo () {
      const userInfo = JSON.parse(window.sessionStorage.getItem('userInfo')) // 获取本地用户信息
      console.log(userInfo)
      const id = userInfo.id
      const author = userInfo.username
      console.log(author)
      if (author === null) {
        this.addArticleData.author = '该用户暂未设置昵称'
      } else {
        this.addArticleData.author = author
      }
      this.addArticleData.user_id = id
    },
    // 发表文章
    async addArticle () {
      const { data: res } = await this.$http.post('index/article/addarticle', this.addArticleData)
      console.log(res)
      if (res.code === 1) {
        this.$alert.success(res.msg)
        this.$router.push('/index')
      } else {
        this.$alert.error(res.msg)
      }
    }
  },
  created () {
    this.getUserInfo()
    this.getAllTags()
  },
  mounted () {}
}
</script>
<style scoped>
/* 标签列表 */
.tagsList{
    list-style: none;
    float: left;
}
/* 父容器清楚浮动 */
.tagsContainer{
    clear: both;
}
/* 标签样式 */
.tagsItem{
    cursor: pointer;
}
.tagsItem::hover{
    background-color: red;
}
</style>
