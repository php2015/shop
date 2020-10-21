<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="名称" prop="name">
        <el-input v-model.trim="form.name" clearable placeholder="名称" style="width:60%" />
      </el-form-item>
      <el-form-item label="Key" prop="key">
        <el-input v-model.trim="form.key" clearable placeholder="Key" style="width:60%" />
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
        name: '',
        key: ''
      },
      rules: {
        name: [{ required: true, message: '请输入名称', trigger: 'blur' }],
        key: [{ required: true, message: '请输入Key', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('wechat.location').then(res => {
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
          save('wechat.location', this.form).then(res => {
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

