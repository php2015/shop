<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-row>
        <el-col :span="14">
          <el-form-item label="系统名称" prop="system_name">
            <el-input v-model="form.system_name" clearable placeholder="系统名称" style="width:80%" />
          </el-form-item>
          <!-- <el-form-item label="版权信息" prop="copyright">
            <el-input v-model="form.copyright" clearable placeholder="版权信息" style="width:80%" />
          </el-form-item> -->
        </el-col>
        <el-col :span="4" style="text-align:center">
          <el-form-item label="LOGO" prop="logo">
            <single-upload
              :action="action"
              :url="url"
              @onSuccess="onSuccess"
            />
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'
import SingleUpload from '@/components/Upload/Single'

export default {
  name: 'SettingSystemIndex',
  components: {
    SingleUpload
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      action: process.env.VUE_APP_BASE_API + '/upload/console.logo/80/80',
      url: '',
      form: {
        system_name: '',
        copyright: '',
        logo: ''
      },
      rules: {
        system_name: [{ required: true, message: '请输入系统名称', trigger: 'blur' }],
        copyright: [{ required: true, message: '请输入版权信息', trigger: 'blur' }],
        logo: [{ required: true, message: '请上传LOGO', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('system.base').then(res => {
        if (res.data) {
          this.form.system_name = res.data.system_name
          this.form.copyright = res.data.copyright
          this.form.logo = res.data.logo
          this.url = res.data.url
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
          save('system.base', this.form).then(res => {
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
      this.form.logo = file.response.data.file
    }
  }
}
</script>

<style>
.logo-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.logo-uploader .el-upload:hover {
  border-color: #409eff;
}
.logo-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 120px;
  height: 120px;
  line-height: 120px;
  text-align: center;
}
.logo {
  width: 120px;
  height: 120px;
  display: block;
}
</style>

