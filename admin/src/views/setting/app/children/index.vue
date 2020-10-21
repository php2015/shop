<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="应用名称" prop="app_name">
        <el-input v-model.trim="form.app_name" clearable placeholder="应用名称" style="width:60%" />
      </el-form-item>
      <!-- <el-form-item label="底部版权信息" prop="copyright">
        <el-input v-model="form.copyright" type="textarea" :autosize="{minRows: 2, maxRows: 6}" clearable placeholder="底部版权信息" style="width:60%" />
      </el-form-item> -->
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingAppBase',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        app_name: '',
        copyright: ''
      },
      rules: {
        app_name: [{ required: true, message: '请输入应用名称', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    get('app.base').then(res => {
      if (res.data) {
        this.form = res.data
      }
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
          save('app.base', this.form).then(res => {
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

