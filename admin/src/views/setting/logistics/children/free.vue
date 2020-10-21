<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="是否开启免邮" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button border :label="10">关闭</el-radio-button>
          <el-radio-button border :label="20">开启</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <section v-if="form.status == 20">
        <el-form-item label="类型" prop="type">
          <el-radio-group v-model="form.type">
            <el-radio-button border :label="10">消费金额</el-radio-button>
            <el-radio-button border :label="20">购买件数</el-radio-button>
          </el-radio-group>
          <div style="padding-top: 10px;">
            <el-alert :closable="false" type="info">
              <div slot="title" style="line-height: 30px;">
                <div>
                  单笔订单满足指定“金额”或则指定“件数”可免邮费。
                </div>
              </div>
            </el-alert>
          </div>
        </el-form-item>
        <el-form-item label="满额标准" prop="limit">
          <el-input-number v-model.number="form.limit" :precision="form.type == 10 ? 2 : 0" :min="0" />
        </el-form-item>
      </section>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingLogisticsFree',
  components: { },
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        status: 10,
        type: 10,
        limit: 0
      },
      rules: {
        limit: [{ required: true, message: '请输入满额标准', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    get('logistics.free')
      .then(res => {
        if (res.data) {
          this.form.status = res.data.status
          this.form.type = res.data.type
          this.form.limit = res.data.limit
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
          save('logistics.free', this.form)
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

