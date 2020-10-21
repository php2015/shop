<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="商户号" prop="mch_id">
        <el-input v-model.trim="form.mch_id" clearable placeholder="商户号" style="width:60%" />
      </el-form-item>
      <el-form-item label="支付密钥" prop="mch_key">
        <el-input v-model.trim="form.mch_key" clearable placeholder="支付密钥" style="width:60%" />
      </el-form-item>
      <el-form-item label="apiclient_cert.pem" prop="apiclient_cert">
        <el-input
          v-model="form.apiclient_cert"
          type="textarea"
          :rows="5"
          clearable
          placeholder="使用文本编辑器打开apiclient_cert.pem文件，将文件的全部内容粘贴到这里"
          style="width:60%"
        />
      </el-form-item>
      <el-form-item label="apiclient_key.pem" prop="apiclient_key">
        <el-input
          v-model="form.apiclient_key"
          type="textarea"
          :rows="5"
          clearable
          placeholder="使用文本编辑器打开apiclient_key.pem文件，将文件的全部内容粘贴到这里"
          style="width:60%"
        />
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
  name: 'SettingWechatPayment',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        mch_id: '',
        mch_key: '',
        apiclient_cert: '',
        apiclient_key: ''
      },
      rules: {
        mch_id: [{ required: true, message: '请输入商户号', trigger: 'blur' }],
        mch_key: [{ required: true, message: '请输入支付密钥', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('wechat.payment').then(res => {
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
          save('wechat.payment', this.form).then(res => {
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

