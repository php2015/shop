<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="图片" prop="image">
        <upload-single :action="action" :url="url" :width="80" :height="80" @onSuccess="onSuccess" />
      </el-form-item>
      <el-form-item label="分类名称" prop="category_name">
        <el-input v-model.trim="form.category_name" clearable placeholder="分类名称" style="width:50%" />
      </el-form-item>
      <el-form-item label="上级分类" prop="parent_id">
        <tree-select
          v-model="form.parent_id"
          :options="parent"
          :normalizer="normalizer"
          :default-expand-level="0"
          placeholder="上级分类"
          style="width:50%"
        />
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
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
import { edit, doEdit } from '@/api/goods/category'
import UploadSingle from '@/components/Upload/Single'
import treeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  name: 'GoodsCategoryEdit',
  components: {
    UploadSingle,
    treeSelect
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      parent: [],
      action: process.env.VUE_APP_BASE_API + '/upload/goods.category/300/300',
      url: '',
      form: {
        id: null,
        parent_id: null,
        image: '',
        category_name: '',
        sort: 100,
        status: 0
      },
      rules: {
        category_name: [{ required: true, message: '请输入分类名称', trigger: 'blur' }]
      }
    }
  },
  computed: {},
  watch: {},
  created () {
    this.loading = true
    edit(this.$route.params.id)
      .then(res => {
        this.parent = res.data.parent
        this.form = res.data.detail
        this.form.parent_id = res.data.detail.parent_id === 0 ? null : res.data.detail.parent_id
        this.url = res.data.detail.image_url
      })
      .finally(() => {
        this.loading = false
      })
  },
  mounted () { },
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
            this.$router.replace('/goods/category')
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
    },

    normalizer (node) {
      if (node.children && !node.children.length) {
        delete node.children
      }
      return {
        id: node.id,
        label: node.category_name,
        children: node.children
      }
    }
  }
}
</script>

<style>
/* ... */
</style>
