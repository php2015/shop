<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item label="商品白底图" prop="image">
        <el-alert type="info" :closable="false" style="margin-bottom: 5px; line-height: 1.15; width: 80%">
          <strong>商品列表页面使用，</strong>文件格式JPEG/PNG/GIF，图片大小不能超过5MB，图片尺寸建议300*300
        </el-alert>
        <upload-single
          :action="imageAction"
          :url="image_url"
          :width="100"
          :height="100"
          @onSuccess="handleImageSuccess"
        />
      </el-form-item>
      <el-form-item label="商品主图" prop="image_list">
        <el-alert type="info" :closable="false" style="margin-bottom: 5px; line-height: 1.15; width: 80%">
          <strong>商品详情页使用，</strong>文件格式 JPEG/PNG/GIF，图片大小不能超过5MB，图片尺寸建议800*800以上
        </el-alert>
        <upload-images
          :action="imageListAction"
          :file-list="image_list"
          @onSuccess="handleBannerSuccess"
          @onRemove="handleBannerRemove"
        />
      </el-form-item>
      <el-form-item label="商品详情" prop="content">
        <tinymce v-model="content" :height="300" />
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
import { content, doContent } from '@/api/goods'
import UploadImages from '@/components/Upload/Images'
import UploadSingle from '@/components/Upload/Single'
import Tinymce from '@/components/Tinymce'

export default {
  name: 'GoodsEditContent',
  components: {
    UploadImages,
    UploadSingle,
    Tinymce
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      imageAction: process.env.VUE_APP_BASE_API + '/upload/goods.image/300/300',
      imageListAction: process.env.VUE_APP_BASE_API + '/upload/goods.banner',
      image_url: '',
      image_list: [],
      content: '',
      form: {
        id: 0,
        image: '',
        image_list: [],
        content: ''
      },
      rules: {
        image: [{ required: true, message: '请上传商品主图', trigger: 'change' }],
        image_list: [{ required: true, message: '请至少上传一张商品图片', trigger: 'change' }]
      }
    }
  },
  watch: {
    content () {
      this.form.content = encodeURIComponent(this.content)
    }
  },
  created () {
    this.loading = true
    content(this.id)
      .then(res => {
        const { data } = res
        this.image_url = data.image_url
        this.image_list = data.images
        this.form.id = data.id
        this.form.image = data.image
        this.form.image_list = data.images
        this.content = data.content
        this.form.content = data.content
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
          doContent(this.form).then(res => {
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

    handleImageSuccess (file) {
      this.form.image = file.response.data.file
      this.$refs.form.validateField('image')
    },

    handleBannerSuccess (fileList) {
      this.form.image_list = fileList
      this.$refs.form.validateField('image_list')
    },

    handleBannerRemove (fileList) {
      this.form.image_list = fileList
      this.$refs.form.validateField('image_list')
    }
  }
}
</script>

<style scoped>
/*  */
</style>

