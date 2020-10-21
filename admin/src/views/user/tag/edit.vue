<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="标签名称" prop="tag_name">
        <el-input v-model.trim="form.tag_name" clearable placeholder="标签名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
        <el-tooltip content="数值越小越靠前" placement="top">
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-form-item label="说明" prop="intro">
        <el-input v-model="form.intro" placeholder="说明" type="textarea" style="width:80%" />
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
import { edit, doEdit } from '@/api/user/tag'

export default {
  name: 'UserTagEdit',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        id: null,
        tag_name: '',
        sort: 100
      },
      rules: {
        tag_name: [{ required: true, message: '请输入标签名称', trigger: 'blur' }],
        sort: [{ required: true, message: '', trigger: 'blur' }]
      }
    }
  },
  computed: {},
  watch: {},
  created () {
    this.loading = true
    edit(this.$route.params.id)
      .then(res => {
        this.form = res.data
        this.url = res.data.url
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
    }
  }
}
</script>

<style>
/* ... */
</style>
