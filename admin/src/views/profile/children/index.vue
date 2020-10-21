<template>
  <div class="app-container">
    <h3>基本信息</h3>
    <el-divider />

    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-row>
        <el-col :span="14">
          <el-form-item label="姓名" prop="realname">
            <el-input
              v-model.trim="form.realname"
              placeholder="姓名"
              style="width:80%"
              @keyup.enter.native="handleSubmit"
            />
          </el-form-item>
          <el-form-item label="邮箱" prop="email">
            <el-input v-model.trim="form.email" placeholder="邮箱" style="width:80%" />
          </el-form-item>
          <el-form-item label="手机号" prop="phone">
            <el-input v-model.trim="form.phone" placeholder="手机号" style="width:80%" />
          </el-form-item>
          <el-form-item label="简介" prop="intro">
            <el-input
              v-model="form.intro"
              placeholder="简介"
              type="textarea"
              :autosize="{ minRows: 2, maxRows: 4}"
              style="width:80%"
            />
          </el-form-item>
          <el-button type="primary" :loading="submitLoading" @click="handleSubmit">更新基本信息</el-button>
        </el-col>
        <el-col :span="4" style="text-align:center">
          <el-form-item label="头像">
            <upload-single
              :action="action"
              :url="form.avatar_url"
              @onSuccess="onSuccess"
            />
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import { info, setInfo } from '@/api/profile'
import { validPhone } from '@/utils/validate'
import UploadSingle from '@/components/Upload/Single'

export default {
  name: 'ProfileBase',
  components: {
    UploadSingle
  },
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
    return {
      loading: false,
      submitLoading: false,
      action: process.env.VUE_APP_BASE_API + '/upload/console.avatar/128/128',
      form: {
        realname: '',
        email: '',
        phone: '',
        intro: '',
        avatar: ''
      },
      rules: {
        realname: [{ required: true, message: '请输入您的姓名', trigger: 'blur' }],
        email: [{ required: true, message: '请输入正确的邮箱', trigger: 'blur', type: 'email' }],
        phone: [{ trigger: 'blur', validator: phone }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      info().then(res => {
        this.form = res.data
        this.avatar_url = res.data.avatar_url
      })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          setInfo(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    onSuccess (file) {
      this.form.avatar = file.response.data.file
    }
  }
}
</script>

<style>
/*  */
</style>

