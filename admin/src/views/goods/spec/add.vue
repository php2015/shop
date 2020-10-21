<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="规格名称" prop="name">
        <el-input v-model.trim="form.name" clearable placeholder="规格名称" style="width:80%" />
      </el-form-item>
      <!-- <el-form-item label="是否搜索项" prop="status">
        <el-radio-group v-model="form.search">
          <el-radio-button label="1">是</el-radio-button>
          <el-radio-button label="0">否</el-radio-button>
        </el-radio-group>
      </el-form-item> -->
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
import { add, doAdd } from '@/api/goods/spec'

export default {
  name: 'GoodsSpecAdd',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        name: '',
        search: 10,
        sort: 100
      },
      rules: {
        name: [{ required: true, message: '请输入规格名称', trigger: 'blur' }]
      }
    }
  },
  created () {
    add().then(res => {
      this.form.sort = res.data.sort
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

<style scoped>
/*  */
</style>
