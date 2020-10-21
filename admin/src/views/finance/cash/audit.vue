<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <!-- <el-divider content-position="left">提现信息</el-divider>
      <el-form-item label="提现编号：">{{ detail.cash_no }}</el-form-item>
      <el-form-item label="提现金额：">{{ detail.cash_apply }}</el-form-item>
      <el-form-item label="手续费：">￥{{ detail.cash_fee }}</el-form-item>
      <el-form-item label="实际到账金额：">{{ detail.cash_amount }}</el-form-item>
      <el-form-item label="提现状态：">
        <el-tag v-if="detail.cash_status == 10" type="info" effect="dark">申请中</el-tag>
        <el-tag v-if="detail.cash_status == 20" type="success" effect="dark">已完成</el-tag>
      </el-form-item>
      <el-form-item label="用户：">{{ detail.user && detail.user.nickname }}</el-form-item>
      <el-form-item label="客户端IP：">{{ detail.client_ip }}</el-form-item>
      <el-form-item label="提现申请时间：">{{ detail.cash_time }}</el-form-item>
      <el-form-item label="提现完成时间：">{{ detail.finish_time }}</el-form-item>
      <el-divider content-position="left">审核信息</el-divider> -->
      <section v-if="detail.cash_status == 10">
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
      </section>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">返 回</el-button>
    </footer>
  </div>
</template>

<script>
import { audit, doAudit } from '@/api/finance/cash'

export default {
  name: 'FinanceCashAudit',
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
    audit(this.$route.params.id)
      .then(res => {
        this.detail = res.data
        this.form.id = this.detail.id
        this.form.cash_status = this.detail.cash_status
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
          doAudit(this.form).then(res => {
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

