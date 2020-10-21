<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="海报图片" prop="image_list">
        <upload-images
          :action="action"
          :file-list="image_list"
          @onSuccess="handleSuccess"
          @onRemove="handleRemove"
        />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="文件格式JPEG/PNG/GIF，图片大小不能超过5MB，图片尺寸建议 800 * 1260" />
        </div>
      </el-form-item>
      <el-form-item label="海报标题" prop="title">
        <el-input v-model.trim="form.title" placeholder="海报标题" style="width:80%" />
      </el-form-item>
      <el-form-item label="海报副标题" prop="subtitle">
        <el-input v-model.trim="form.subtitle" placeholder="海报副标题" style="width:80%" />
      </el-form-item>
      <el-form-item label="规则说明" prop="content">
        <tinymce v-model="content" :height="300" />
      </el-form-item>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'
import UploadImages from '@/components/Upload/Images'
import Tinymce from '@/components/Tinymce'

export default {
  name: 'SettingAppInvite',
  components: {
    UploadImages,
    Tinymce
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      action: process.env.VUE_APP_BASE_API + '/upload/invite.poster',
      image_list: [],
      content: '',
      form: {
        image_list: [],
        title: '',
        subtitle: '',
        content: ''
      },
      rules: {
        image_list: [
          {
            required: true,
            message: '请至少上传一张海报图片',
            trigger: 'change'
          }
        ],
        title: [{ required: true, message: '请输入海报标题', trigger: 'blur' }]
      }
    }
  },
  watch: {
    content () {
      this.form.content = encodeURIComponent(this.content)
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('app.invite')
        .then(res => {
          if (res.data) {
            const { data } = res
            this.image_list = data.image_list
            this.form.image_list = data.image_list
            this.form.title = data.title
            this.form.subtitle = data.subtitle
            this.content = data.content
          }
        })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.submitLoading = true
          save('app.invite', this.form)
            .then(res => {
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

    handleSuccess (fileList) {
      this.form.image_list = fileList
    },

    handleRemove (fileList) {
      this.form.image_list = fileList
    }
  }
}
</script>

<style>
/*  */
</style>

