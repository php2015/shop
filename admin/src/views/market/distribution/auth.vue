<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="审核状态" prop="audit_status">
        <el-radio-group v-model="form.audit_status">
          <el-radio-button border :label="10">拒绝</el-radio-button>
          <el-radio-button border :label="20">通过</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="备注信息" prop="remark">
        <el-input
          v-model="form.remark"
          type="textarea"
          :autosize="{ minRows: 2, maxRows: 4}"
          placeholder="如拒绝申请，请输入审核说明。"
          style="width:80%"
        />
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">返 回</el-button>
    </footer>
  </div>
</template>

<script>
import { auth, doAuth } from '@/api/market/distribution'

export default {
  name: 'MarketDistributionAuth',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      detail: {},
      form: {
        id: null,
        audit_status: 10,
        remark: ''
      },
      rules: {
        id: [{ required: true, message: 'ID为空', trigger: 'change' }],
        audit_status: [{ required: true, message: '审核状态', trigger: 'change' }]
      }
    }
  },
  created () {
    this.loading = true
    auth(this.$route.params.id)
      .then(res => {
        this.detail = res.data
        this.form.id = this.detail.id
        this.form.audit_status = this.detail.audit_status
        this.form.remark = this.detail.remark
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
          doAuth(this.form).then(res => {
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

