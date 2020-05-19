<template>
    <div>
        <!-- 面包屑导航栏 -->
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/welcome' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>权限管理</el-breadcrumb-item>
            <el-breadcrumb-item>权限列表</el-breadcrumb-item>
        </el-breadcrumb>
        <!-- 卡片 -->
        <el-card class="box-card">
        <!-- 用户权限列表 -->
            <el-table :data="rightsTable" stripe style="width: 100%" border>
                <el-table-column type="index" label="序号" width="150"></el-table-column>
                <el-table-column
                prop="authName"
                label="权限名称"
                width="400">
                </el-table-column>
                <el-table-column
                prop="path"
                label="路径"
                width="400">
                </el-table-column>
                <el-table-column
                prop="level"
                label="权限等级">
                <template slot-scope="scope">
                <el-tag v-if="scope.row.level === '0'">一级</el-tag>
                <el-tag type="warning" v-else-if="scope.row.level === '1'">二级</el-tag>
                <el-tag type="danger" v-else>三级</el-tag>
                </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
</template>
<script>
export default {
  data() {
    return {
      rightsTable: []
    }
  },
  methods: {
    async getrightList() {
      const { data: res } = await this.$http.get('rights/list')
      console.log(res)
      if (res.meta.status !== 200) return this.$alert.error('获取列表失败！')
      this.rightsTable = res.data
    }
  },
  created() {
    this.getrightList()
  }
}
</script>
<style lang="less">
.cell {
    text-align: center;
}
</style>
