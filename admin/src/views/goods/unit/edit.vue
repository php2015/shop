<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="单位" prop="unit">
        <el-input v-model.trim="form.unit" clearable placeholder="单位" style="width:80%" />
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
        <el-tooltip content="数值越小越靠前" placement="top">
          <i class="el-icon-question" />
        </el-tooltip>
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
import { edit, doEdit } from '@/api/goods/unit'

export default {
  name: 'GoodsUnitEdit',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        id: null,
        unit: '',
        sort: 100
      },
      rules: {
        unit: [{ required: true, message: '请输入单位名称', trigger: 'blur' }],
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
