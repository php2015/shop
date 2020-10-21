<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-tabs type="border-card">
        <!-- 基本 -->
        <el-tab-pane label="基础设置">
          <el-form-item label="库存策略" prop="stock">
            <el-radio-group v-model="form.stock">
              <el-radio-button border :label="10">下单减库存</el-radio-button>
              <el-radio-button border :label="20">支付减库存</el-radio-button>
            </el-radio-group>
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info">
                <div slot="title" style="line-height: 30px;">
                  <div>
                    <strong>下单减库存：</strong>用户提交订单后减库存。
                  </div>
                  <div>
                    <strong>支付减库存：</strong>用户支付成功后减库存。
                  </div>
                </div>
              </el-alert>
            </div>
          </el-form-item>
          <el-form-item label="开具发票" prop="invoice">
            <el-radio-group v-model="form.invoice">
              <el-radio-button border :label="10">不支持</el-radio-button>
              <el-radio-button border :label="20">支持</el-radio-button>
            </el-radio-group>
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info">
                <div slot="title" style="line-height: 30px;">
                  选择支持开发票后,用户在提交订单时可选择是否开发票。
                </div>
              </el-alert>
            </div>
          </el-form-item>
          <el-form-item label="关闭订单(分钟)" prop="close">
            <el-input-number v-model.number="form.close" :min="0" :max="15" style="width: 200px" />
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info" title="订单未支付 N 分钟之后自动关闭，0为不自动关闭。" />
            </div>
          </el-form-item>
          <el-form-item label="自动收货(天)" prop="receive">
            <el-input-number v-model.number="form.receive" :min="0" :max="15" style="width: 200px" />
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info" title="订单支付 N 天之后自动收货，0为不自动收货。" />
            </div>
          </el-form-item>
        </el-tab-pane>
        <!-- 短信 -->
        <el-tab-pane label="短信通知">
          <el-form-item label="接收人手机号" prop="sms_receiver">
            <el-input
              v-model="form.sms_receiver"
              :autosize="{ minRows: 2, maxRows: 4}"
              type="textarea"
              placeholder="新订单短信接收人手机号"
              style="width:60%"
            />
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info">
                <div slot="title" style="line-height: 30px;">
                  多个手机号码请用半角逗号分隔。
                </div>
              </el-alert>
            </div>
          </el-form-item>
        </el-tab-pane>
      </el-tabs>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingAppOrder',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        stock: 10,
        close: 15,
        invoice: 10,
        sms_receive: ''
      },
      rules: {
        close: [{ required: true, message: '请输入自动关闭订单的时间', trigger: 'blur' }],
        receive: [{ required: true, message: '请输入自动收货的时间', trigger: 'blur' }],
        stock: [{ required: true, message: '请选择库存策略', trigger: 'change' }],
        invoice: [{ required: true, message: '请选择是否开具发票', trigger: 'change' }]
      }
    }
  },
  created () {
    this.loading = true
    get('app.order').then(res => {
      if (res.data) {
        this.form = res.data
      }
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
          save('app.order', this.form).then(res => {
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

