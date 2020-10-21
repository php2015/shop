<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="图片" prop="image">
        <upload-single
          :action="action"
          @onSuccess="onSuccess"
        />
      </el-form-item>
      <el-form-item label="分类" prop="category_id">
        <el-select v-model="form.category_id" clearable placeholder="请选择分类" style="width:80%">
          <el-option
            v-for="(item, index) in category"
            :key="index"
            :label="item.category_name"
            :value="item.id"
            :disabled="item.status == 10"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="标题" prop="title">
        <el-input v-model.trim="form.title" clearable placeholder="标题" style="width:80%" />
      </el-form-item>
      <el-form-item label="副标题" prop="subtitle">
        <el-input v-model.trim="form.subtitle" clearable placeholder="副标题" style="width:80%" />
      </el-form-item>
      <el-form-item label="风格" prop="style">
        <el-radio-group v-model="form.style">
          <el-radio-button :label="10">大图</el-radio-button>
          <el-radio-button :label="20">左图</el-radio-button>
          <el-radio-button :label="30">右图</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="推荐" prop="is_best">
        <el-switch
          v-model="form.is_best"
          active-color="#13ce66"
          :inactive-value="10"
          :active-value="20"
        />
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button :label="10">下线</el-radio-button>
          <el-radio-button :label="20">上线</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="内容" prop="content">
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
import { add, doAdd } from '@/api/article'
import UploadSingle from '@/components/Upload/Single'
import Tinymce from '@/components/Tinymce'

export default {
  name: 'ArticleAdd',
  components: {
    UploadSingle,
    Tinymce
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      action: process.env.VUE_APP_BASE_API + '/upload/article.image/',
      category: [],
      content: '',
      form: {
        category_id: null,
        image: '',
        title: '',
        subtitle: '',
        style: 10,
        sort: 100,
        is_best: 10,
        status: 10,
        content: ''
      },
      rules: {
        category_id: [{ required: true, message: '请选择分类', trigger: 'change' }],
        image: [{ required: true, message: '请上传图片', trigger: 'blur' }],
        title: [{ required: true, message: '请输入标题', trigger: 'blur' }]
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
    add().then(res => {
      this.category = res.data.category
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

