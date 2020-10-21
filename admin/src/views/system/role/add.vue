<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="角色名称" prop="role_name">
        <el-input v-model.trim="form.role_name" placeholder="模块名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="简介" prop="intro">
        <el-input v-model="form.intro" placeholder="简介" type="textarea" style="width:80%" />
      </el-form-item>
      <el-form-item label="模块权限" prop="module">
        <el-tree
          ref="tree"
          node-key="id"
          :data="module"
          show-checkbox
          :default-checked-keys="[]"
          :props="defaultProps"
        />
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
import { add, doAdd } from '@/api/system/role'

export default {
  name: 'RoleAdd',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      module: [],
      defaultProps: {
        label: 'module_name'
      },
      form: {
        role_name: '',
        module: '',
        intro: ''
      },
      rules: {
        role_name: [{ required: true, message: '请输入角色名称', trigger: 'blur' }],
        module: [{ required: true, message: '请选择模块权限', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    add().then(res => {
      this.module = res.data.module
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      this.form.module = this.$refs.tree.getHalfCheckedKeys().concat(
        this.$refs.tree.getCheckedKeys()
      ).toString()

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
    }
  }
}
</script>

<style scoped>
/*  */
</style>

