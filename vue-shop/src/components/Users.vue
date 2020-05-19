<template>
    <div>
        <!-- 面包屑导航 -->
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/home' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>用户管理</el-breadcrumb-item>
            <el-breadcrumb-item>用户列表</el-breadcrumb-item>
        </el-breadcrumb>
        <!-- 卡片内容 -->
        <el-card class="box-card" >
            <!-- 对话框存放区域 -->
            <!-- 添加用户对话框 -->
              <el-dialog
              title="添加用户"
              :visible.sync="AdddialogVisible"
              width="40%"
              @close="adddialogReset">
              <!-- 主体区域 -->
              <el-form  label-width="70px" :model="AddForm" :rules="Addrules" ref="AddFormRefs">
                <el-form-item label="用户名" prop="username">
                  <el-input v-model="AddForm.username"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                  <el-input type="password" v-model="AddForm.password"></el-input>
                </el-form-item>
                <el-form-item label="手机" prop="mobile">
                  <el-input  v-model="AddForm.mobile"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                  <el-input  v-model="AddForm.email"></el-input>
                </el-form-item>
              </el-form>
              <!-- 底部按钮 -->
              <span slot="footer" class="dialog-footer">
                <el-button @click="AdddialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="addUser">确 定</el-button>
              </span>
              </el-dialog>
            <!-- 编辑用户对话框 -->
              <el-dialog
              title="修改用户信息"
              :visible.sync="editdialogVisible"
              width="40%"
              :close="editdialogReset">
              <!-- 编辑对话框主体内容 -->
                <el-form ref="editFormRef" :model="editForm" :rules="editRules" label-width="80px">
                  <el-form-item label="用户名">
                    <el-input v-model="editForm.username" :disabled="true"></el-input>
                  </el-form-item>
                  <el-form-item label="邮箱" prop="email">
                    <el-input v-model="editForm.email"></el-input>
                  </el-form-item>
                  <el-form-item label="手机号码" prop="mobile">
                    <el-input v-model="editForm.mobile"></el-input>
                  </el-form-item>
                </el-form>
              <!--编辑对话框底部内容  -->
                <span slot="footer" class="dialog-footer">
                  <el-button @click="editdialogVisible = false">取 消</el-button>
                  <el-button type="primary" @click="saveEdit">确 定</el-button>
                </span>
            </el-dialog>
            <!-- 上半部分 -->
            <el-row :gutter="20">
                <!-- 搜索 -->
                <el-col :span="8">
                    <el-input placeholder="请输入内容" v-model="QueryInfo.query" clearable @clear="getUserList">
                        <el-button slot="append" icon="el-icon-search" @click="getUserList"></el-button>
                    </el-input>
                </el-col>
                <!-- 添加用户 -->
                <el-col :span="4">
                    <el-button type="primary" @click="AdddialogVisible = true">添加用户</el-button>
                </el-col>
            </el-row>
            <!-- 表格 -->
            <el-table :data="tableData" stripe style="width:100%">
                <el-table-column type="index" label="序号" width="180"></el-table-column>
                <el-table-column
                prop="username"
                label="账号"
                width="180">
                </el-table-column>
                <el-table-column
                prop="mobile"
                label="电话">
                </el-table-column>
                <el-table-column
                prop="email"
                label="邮箱">
                </el-table-column>
                <el-table-column
                prop="mg_state"
                label="状态">
                <template slot-scope="scope">
                   <el-switch v-model="scope.row.mg_state" @change="UserStateChange(scope.row)">
                   </el-switch>
                </template>
                </el-table-column>
                <el-table-column
                prop="role_name"
                label="身份">
                </el-table-column>
                <el-table-column>
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-button type="primary" icon="el-icon-edit" @click="editUser(scope.row.id)"></el-button>
                            <el-button type="danger" icon="el-icon-delete" @click="deleteUser(scope.row.id)"></el-button>
                            <el-button type="warning" icon="el-icon-setting"></el-button>
                        </el-button-group>
                    </template>
                </el-table-column>
            </el-table>
            <!-- 分页 -->
              <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="QueryInfo.pagenum"
              :page-sizes="[1, 2, 5, 10]"
              :page-size="QueryInfo.pagesize"
              layout="total, sizes, prev, pager, next, jumper"
              :total="total">
              </el-pagination>
        </el-card>
    </div>
</template>
<script>
export default {
  data() {
    // 邮箱验证
    var checkEmail = (rule, value, callback) => {
      const regEmail = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
      setTimeout(() => {
        if (regEmail.test(value)) { return callback() }
        callback(new Error('请输入合法邮箱'))
      }, 1000)
    }
    // 手机号验证
    var checkMobile = (rule, value, callback) => {
      const regMobile = /^1(3|4|5|6|7|8|9)\d{9}$/
      setTimeout(() => {
        if (regMobile.test(value)) { return callback() }
        callback(new Error('请输入正确的电话号码'))
      }, 1000)
    }
    return {
      QueryInfo: {
        //   查询参数
        query: '',
        // 当前页码
        pagenum: 1,
        // 每页显示条数
        pagesize: 2
      },
      tableData: [],
      //   总记录数
      total: 0,
      // 对话框得显示隐藏
      AdddialogVisible: false,

      // 添加数据
      AddForm: {
        username: '',
        password: '',
        mobile: '',
        email: ''
      },
      // 添加验证
      Addrules: {
        username: [
          { required: true, message: '请输入用户名', trigger: 'blur' },
          { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '请输入密码', trigger: 'blur' }
        ],
        mobile: [
          { required: true, message: '请输入手机号', trigger: 'blur' },
          { validator: checkMobile, trigger: 'blur' }
        ],
        email: [
          { required: true, message: '请输入邮箱号', trigger: 'blur' },
          { validator: checkEmail, trigger: 'blur' }
        ]
      },
      // 编辑对话框的显示隐藏
      editdialogVisible: false,
      // 编辑对话框表格数据
      editForm: {
        username: '',
        email: '',
        mobile: ''
      },
      // 编辑对话框验证
      editRules: {
        mobile: [
          { required: true, message: '请输入手机号', trigger: 'blur' },
          { validator: checkMobile, trigger: 'blur' }
        ],
        email: [
          { required: true, message: '请输入邮箱号', trigger: 'blur' },
          { validator: checkEmail, trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    //   获取用户列表
    async getUserList() {
      const { data: res } = await this.$http.get('users', { params: this.QueryInfo })
      console.log(res)
      if (res.meta.status !== 200) { return this.$message.error('获取用户信息失败') }
      this.tableData = res.data.users
      this.total = res.data.total
    },
    // 当前页几条内容
    handleSizeChange(newSize) {
      this.QueryInfo.pagesize = newSize
      this.getUserList()
    },
    // 当前页
    handleCurrentChange(newSize) {
      console.log(`当前页: ${newSize}`)
      this.QueryInfo.pagenum = newSize
      this.getUserList()
    },
    // 同步状态
    async UserStateChange(userinfo) {
      console.log(userinfo)
      const { data: res } = await this.$http.put(`users/${userinfo.id}/state/${userinfo.mg_state}`)
      console.log(res)
      if (res.meta.status !== 200) {
        this.userinfo.mg_state = !this.userinfo.mg_state
        return this.$alert.error('更新用户状态失败！')
      }
      this.$alert.success('更新用户状态成功！')
    },
    // 对话框关闭监听重置事件
    adddialogReset() {
      this.$refs.AddFormRefs.resetFields()
    },
    // 添加用户事件
    addUser() {
      this.$refs.AddFormRefs.validate(async valid => {
        console.log(valid)
        if (!valid) return
        const { data: res } = await this.$http.post('users', this.AddForm)
        console.log(res)
        if (res.meta.status !== 201) { return this.alert.error('添加用户失败') }
        this.$alert.success('添加用户成功')
        this.AdddialogVisible = false
        this.getUserList()
      })
    },
    // 修改用户对话框出现相应内容事件
    async editUser(id) {
      this.editdialogVisible = true
      const { data: res } = await this.$http.get('users/' + id)
      console.log(res)
      if (res.meta.status !== 200) return
      this.editForm = res.data
    },
    // 修改对话框监听关闭重置事件
    editdialogReset() {
      this.$refs.editFormRef.resetFields()
    },
    // 保存修改事件
    saveEdit() {
      // 进行表单提交的预验证
      this.$refs.editFormRef.validate(async valid => {
        console.log(valid)
        if (!valid) return this.$alert.error('预验证失败！')
        const { data: res } = await this.$http.put('user/' + this.editForm.id, { email: this.editForm.email, mobile: this.editForm.mobile })
        if (res.meta.status === 404) return this.$alert.error('修改用户信息失败')
        this.$alert.success('修改成功！')
        this.editdialogVisible = false
        this.getUserList()
      })
    },
    // 点击删除事件
    async deleteUser(id) {
      console.log(id)
      const res = await this.$confirm('是否删除该用户？', '确认信息', {
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).catch(err => { return err })
      if (res === 'cancel') return
      if (res === 'confirm') {
        const delres = await this.$http.delete('users/' + id)
        if (delres.status !== 200 && id === 500) { return this.$alert.error('删除失败！') } else if (id === 500) { return this.$alert.error('admin账号不能删除') }
        this.$alert.success('删除成功')
        this.getUserList()
      }
    }
  },
  created() {
    this.getUserList()
  }
}
</script>
<style lang="less">
.el-breadcrumb{
    margin-bottom: 20px;
}
</style>
