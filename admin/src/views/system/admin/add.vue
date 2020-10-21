<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="角色" prop="role_id">
        <el-select v-model="form.role_id" clearable placeholder="请选择角色" style="width:80%">
          <el-option v-for="item in role" :key="item.id" :label="item.role_name" :value="item.id" />
        </el-select>
      </el-form-item>
      <el-form-item label="用户名" prop="username">
        <el-input v-model.trim="form.username" clearable placeholder="用户名" style="width:80%" />
      </el-form-item>
      <el-form-item label="用户密码" prop="password">
        <el-input
          v-model.trim="form.password"
          type="password"
          clearable
          placeholder="用户密码"
          style="width:80%"
        />
      </el-form-item>
      <el-form-item label="姓名" prop="realname">
        <el-input v-model.trim="form.realname" clearable placeholder="姓名" style="width:80%" />
      </el-form-item>
      <el-form-item label="性别" prop="gender">
        <el-radio-group v-model="form.gender">
          <el-radio-button label="1">男</el-radio-button>
          <el-radio-button label="2">女</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="邮箱" prop="email">
        <el-input v-model.trim="form.email" clearable placeholder="邮箱" style="width:80%" />
      </el-form-item>
      <el-form-item label="手机号" prop="phone">
        <el-input v-model.trim="form.phone" clearable placeholder="手机号" style="width:80%" />
      </el-form-item>
      <el-form-item label="状态" prop="disable">
        <el-radio-group v-model="form.disable">
          <el-radio-button label="10">正常</el-radio-button>
          <el-radio-button label="20">禁用</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="简介" prop="intro">
        <el-input v-model="form.intro" placeholder="简介" type="textarea" style="width:80%" />
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/system/admin'
import { validPhone, validEmail } from '@/utils/validate'

export default {
  name: 'AdminAdd',
  data () {
    const phone = (rule, value, callback) => {
      if (value.length > 0) {
        if (validPhone(value)) {
          callback()
        } else {
          return callback(new Error('请输入正确的手机号'))
        }
      } else {
        callback()
      }
    }
    const email = (rule, value, callback) => {
      if (value.length > 0) {
        if (validEmail(value)) {
          callback()
        } else {
          return callback(new Error('请输入正确的邮箱'))
        }
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      role: [],
      form: {
        role_id: null,
        username: '',
        password: '',
        realname: '',
        gender: 1,
        email: '',
        phone: '',
        disable: 10,
        intro: ''
      },
      rules: {
        role_id: [{ required: true, message: '请选择角色' }],
        username: [
          { required: true, message: '请输入用户名', trigger: 'blur' },
          { min: 2, max: 20, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '请输入用户密码', trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符之间', trigger: 'blur' }
        ],
        email: [{ trigger: 'blur', validator: email }],
        phone: [{ trigger: 'blur', validator: phone }]
      }
    }
  },
  created () {
    this.loading = true
    add().then(res => {
      this.role = res.data.role
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
          doAdd(this.form).then(res => {
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>

