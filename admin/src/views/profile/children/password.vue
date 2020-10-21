<template>
  <div class="app-container">
    <h3>修改密码</h3>
    <el-divider />

    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="原始密码" prop="password">
        <el-input
          v-model.trim="form.password"
          type="password"
          placeholder="原始密码"
          style="width:60%"
        />
      </el-form-item>
      <el-form-item label="新密码" prop="new_password">
        <el-input
          v-model.trim="form.new_password"
          type="password"
          placeholder="新密码"
          style="width:60%"
          @keyup.enter.native="handleSubmit"
        />
      </el-form-item>
    </el-form>
    <el-button type="primary" :loading="submitLoading" @click="handleSubmit">更新密码</el-button>
  </div>
</template>

<script>
import { password } from '@/api/profile'

export default {
  name: 'ProfilePassword',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        password: '',
        password2: ''
      },
      rules: {
        password: [
          { required: true, message: '请输入原始密码', trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符之间', trigger: 'blur' }
        ],
        new_password: [
          { required: true, message: '请输入新密码', trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符之间', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          password(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
            this.$refs.form.resetFields()
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    }
  }
}
</script>

<style scoped>
/*  */
</style>

