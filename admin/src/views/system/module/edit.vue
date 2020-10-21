<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="模块名称" prop="module_name">
        <el-input v-model.trim="form.module_name" placeholder="模块名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="上级模块" prop="parent_id">
        <tree-select
          v-model="form.parent_id"
          :options="parent"
          :normalizer="normalizer"
          placeholder="根目录"
          style="width:80%"
        />
      </el-form-item>
      <el-form-item label="前端路由" prop="client_router">
        <el-input v-model.trim="form.client_router" placeholder="前端路由" style="width:80%" />
      </el-form-item>
      <el-form-item label="后端路由" prop="server_router">
        <el-input v-model.trim="form.server_router" placeholder="后端路由" style="width:80%" />
      </el-form-item>
      <el-form-item label="图标" prop="icon">
        <el-input v-model.trim="form.icon" placeholder="图标" style="width:80%" />
      </el-form-item>
      <el-form-item label="是否继承" prop="extend">
        <el-radio-group v-model="form.extend">
          <el-radio-button label="10">否</el-radio-button>
          <el-radio-button label="20">是</el-radio-button>
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
import { edit, doEdit } from '@/api/system/module'
import treeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  name: 'ModuleEdit',
  components: { treeSelect },
  data () {
    return {
      loading: false,
      submitLoading: false,
      parent: [],
      form: {
        id: 0,
        module_name: '',
        parent_id: null,
        icon: '',
        client_router: '',
        server_router: '',
        extend: 0,
        intro: ''
      },
      rules: {
        module_name: [{ required: true, message: '请输入模块名称', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    edit(this.$route.params.id)
      .then(res => {
        this.form = res.data.detail
        this.form.parent_id = res.data.detail.parent_id === 0 ? null : res.data.detail.parent_id
        this.parent = res.data.parent
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    normalizer (node) {
      if (node.children && !node.children.length) {
        delete node.children
      }
      return {
        id: node.id,
        label: node.module_name,
        children: node.children
      }
    },

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
    }
  }
}
</script>

<style scoped>
/*  */
</style>

