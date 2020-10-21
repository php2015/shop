<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item label="提现门槛金额" prop="cash_limit">
        <el-input-number v-model="form.cash_limit" :precision="2" :min="0.3" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="达到该目标金额方可申请提现。" />
        </div>
      </el-form-item>
      <el-form-item label="提现手续费类型" prop="cash_fee_type">
        <el-radio-group v-model="form.cash_fee_type">
          <el-radio-button border :label="10">百分比</el-radio-button>
          <el-radio-button border :label="20">固定金额</el-radio-button>
        </el-radio-group>
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info">
            <div slot="title" style="line-height: 30px;">
              <div>
                <strong>百分比：</strong>按照（提现总金额 X 百分比）收取。
              </div>
              <div>
                <strong>固定金额：</strong>无论多少提现金额，皆采用该固定金额收取。
              </div>
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-form-item label="提现手续费" prop="cash_fee">
        <el-input-number v-model.number="form.cash_fee" :precision="2" :min="0" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="每笔提现收取的手续费。若为固定金额那么手续费不应该大于提现金额。" />
        </div>
      </el-form-item>
      <el-form-item label="锁定期限" prop="cash_lock">
        <el-input-number v-model.number="form.cash_lock" :min="0" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="用户获得的佣金，在N天之后方可提现，此设置避免出现用户购买后退货情况。输入0则立即结算" />
        </div>
      </el-form-item>
      <!-- <el-form-item label="规则说明" prop="content">
        <tinymce v-model="content" :height="300" />
      </el-form-item> -->
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'
// import Tinymce from '@/components/Tinymce'

export default {
  name: 'SettingFinanceCash',
  components: {
    // Tinymce
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      content: '',
      form: {
        cash_limit: 1,
        cash_fee_type: 10,
        cash_fee: 0,
        cash_lock: 0
        // content: ''
      },
      rules: {
        cash_limit: [{ required: true, message: '请输入提现门槛金额', trigger: 'blur' }],
        cash_fee_type: [{ required: true, message: '请选择提现手续费类型', trigger: 'change' }],
        cash_fee: [{ required: true, message: '请输入提现手续费', trigger: 'blur' }],
        cash_lock: [{ required: true, message: '请输入锁定期限', trigger: 'blur' }]
      }
    }
  },
  watch: {
    // content () {
    //   this.form.content = encodeURIComponent(this.content)
    // }
  },
  created () {
    this.loading = true
    get('finance.cash')
      .then(res => {
        if (res.data) {
          this.form.cash_limit = res.data.cash_limit
          this.form.cash_fee_type = res.data.cash_fee_type
          this.form.cash_fee = res.data.cash_fee
          this.form.cash_lock = res.data.cash_lock
          // this.content = res.data.content
        }
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.submitLoading = true
          save('finance.cash', this.form)
            .then(res => {
              this.$message({
                message: res.msg,
                type: 'success'
              })
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

