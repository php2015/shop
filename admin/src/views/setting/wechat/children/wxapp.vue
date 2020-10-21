<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="AppID" prop="app_id">
        <el-input v-model.trim="form.app_id" clearable placeholder="AppID" style="width:60%" />
      </el-form-item>
      <el-form-item label="AppSecret" prop="app_secret">
        <el-input v-model.trim="form.app_secret" clearable placeholder="AppSecret" style="width:60%" />
      </el-form-item>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingWechatWxapp',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        app_id: '',
        app_secret: ''
      },
      rules: {
        app_id: [{ required: true, message: '请输入AppID', trigger: 'blur' }],
        app_secret: [{ required: true, message: '请输入AppSecret', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('wechat.wxapp').then(res => {
        if (res.data) {
          this.form = res.data
        }
      })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          save('wechat.wxapp', this.form).then(res => {
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
    }
  }
}
</script>

<style>
/*  */
</style>

