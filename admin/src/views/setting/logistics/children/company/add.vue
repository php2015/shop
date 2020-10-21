<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="快递公司" prop="company">
          <el-input v-model.trim="form.company" clearable placeholder="快递公司" style="width:80%" />
        </el-form-item>
        <el-form-item label="快递公司代码" prop="code">
          <el-input v-model.trim="form.code" clearable placeholder="快递公司代码" style="width:80%" />
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-tooltip content="数值越小越靠前" placement="top">
            <i class="el-icon-question" />
          </el-tooltip>
        </el-form-item>
      </el-form>
      <footer>
        <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
        <el-button @click="beforeClose">取 消</el-button>
      </footer>
    </el-dialog>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/setting/logistics/company'

export default {
  name: 'SettingLogisticsCompanyAdd',
  components: {},
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        company: '',
        code: '',
        sort: 100
      },
      rules: {
        company: [{ required: true, message: '请输入快递公司', trigger: 'blur' }],
        code: [{ required: true, message: '请输入快递公司代码', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    add()
      .then(res => {
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
            this.$parent.getList()
            this.beforeClose()
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    beforeClose () {
      this.$emit('update:visible', false)
    }
  }
}
</script>

<style scoped>
/*  */
</style>

