<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="绑定人员" prop="user">
        <placeholder-image :width="100" :height="100" :params.sync="form.user" :radio="true" @click="visible = true" />
      </el-form-item>
      <el-form-item label="员工姓名" prop="name">
        <el-input v-model.trim="form.name" clearable placeholder="员工姓名" style="width:80%" />
      </el-form-item>
      <el-form-item label="联系电话" prop="phone">
        <el-input v-model.trim="form.phone" clearable placeholder="联系电话" style="width:80%" />
      </el-form-item>
      <el-form-item label="是否核销员" prop="verify">
        <el-radio-group v-model="form.verify">
          <el-radio-button :label="10">否</el-radio-button>
          <el-radio-button :label="20">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button :label="10">禁用</el-radio-button>
          <el-radio-button :label="20">启用</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
    <dialog-user :visible.sync="visible" :params.sync="form.user" :radio="true" @change="userSelected" />
  </div>
</template>

<script>
import { edit, doEdit } from '@/api/shop/employee'
import PlaceholderImage from '@/components/Placeholder/Image'
import DialogUser from '@/components/Dialog/User'

export default {
  name: 'ShopEmployeeEdit',
  components: {
    PlaceholderImage,
    DialogUser
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      visible: false,
      form: {
        id: null,
        user: [],
        name: '',
        phone: '',
        verify: 10,
        status: 10
      },
      rules: {
        user: [{ required: true, message: '请选择用户', trigger: 'change' }],
        name: [{ required: true, message: '请输入员工姓名', trigger: 'blur' }],
        phone: [{ required: true, message: '请输入联系电话', trigger: 'blur' }],
        verify: [{ required: true, message: '请选择核销员', trigger: 'change' }],
        status: [{ required: true, message: '请选择状态', trigger: 'change' }]
      }
    }
  },
  watch: {},
  created () {
    this.loading = true
    edit(this.$route.params.id)
      .then(res => {
        const { data } = res
        this.form.id = data.id
        this.form.name = data.name
        this.form.phone = data.phone
        this.form.verify = data.verify
        this.form.status = data.status
        this.form.user.push({
          id: data.user.id,
          image: data.user.avatar_url
        })
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          doEdit(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
            this.$router.go(-1)
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    userSelected (data) {
      this.form.user = this.form.user.concat(data)
    }
  }
}
</script>

<style scoped>
/*  */
</style>

