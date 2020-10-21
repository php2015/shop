<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="分组名称" prop="group_name">
        <el-input v-model.trim="form.group_name" clearable placeholder="分组名称" style="width:80%" />
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
import { add, doAdd } from '@/api/goods/group'

export default {
  name: 'GoodsGroupAdd',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        group_name: '',
        sort: 100,
        status: 10
      },
      rules: {
        group_name: [{ required: true, message: '请输入分组名称', trigger: 'blur' }]
      }
    }
  },
  computed: {},
  watch: {},
  created () {
    this.loading = true
    add().then(res => {
      this.form.sort = res.data.sort
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
    }
  }
}
</script>

<style>
/*  */
</style>
