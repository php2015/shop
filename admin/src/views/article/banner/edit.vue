<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
      <el-form-item label="图片" prop="image">
        <single-upload
          :action="action"
          :url="form.image_url"
          @onSuccess="onSuccess"
        />
      </el-form-item>
      <el-form-item label="标题" prop="title">
        <el-input v-model.trim="form.title" placeholder="标题" style="width:80%" />
      </el-form-item>
      <el-form-item label="跳转" prop="redirect_type">
        <el-radio-group v-model="form.redirect_type">
          <el-radio-button label="0">不跳转</el-radio-button>
          <el-radio-button label="1">跳转</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="跳转地址" prop="redirect_site">
        <el-input v-model.trim="form.redirect_site" placeholder="跳转地址" style="width:80%" />
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input v-model.number="form.sort" placeholder="数值越小越靠前" style="width:80%" />
        <el-tooltip content="数值越小越靠前" placement="top">
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button label="10">下线</el-radio-button>
          <el-radio-button label="20">上线</el-radio-button>
        </el-radio-group>
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
import { edit, doEdit } from '@/api/article/banner'
import SingleUpload from '@/components/Upload/Single'

export default {
  name: 'ArticleBannerEdit',
  components: {
    SingleUpload
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      action: process.env.VUE_APP_BASE_API + '/upload/article.banner',
      url: '',
      form: {
        id: '',
        image: '',
        title: '',
        redirect_type: 0,
        redirect_site: '',
        sort: 100,
        status: 10
      },
      rules: {
        image: [{ required: true, message: '请上传图片', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    edit(this.$route.params.id)
      .then(res => {
        this.form = res.data
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

    onSuccess (file) {
      this.form.image = file.response.data.file
    }
  }
}
</script>

<style scoped>
/*  */
</style>

