<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="配送方式" prop="method">
        <el-checkbox-group v-model="form.method" :min="1">
          <el-checkbox :label="10">快递发货</el-checkbox>
          <el-checkbox :label="20">同城配送</el-checkbox>
          <el-checkbox :label="30">上门自提</el-checkbox>
        </el-checkbox-group>
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="商城所支持的所有配送方式，至少选择一个。" />
        </div>
      </el-form-item>
      <el-form-item label="是否支持当日自提" prop="today_fetch">
        <el-radio-group v-model="form.today_fetch">
          <el-radio-button border :label="10">否</el-radio-button>
          <el-radio-button border :label="20">是</el-radio-button>
        </el-radio-group>
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="支持则显示当日可以自提时间段供选择，否则只显示明日可自提时间段。" />
        </div>
      </el-form-item>
      <el-form-item label="运费策略" prop="freight">
        <el-radio-group v-model="form.freight">
          <el-radio-button border :label="10">叠加</el-radio-button>
          <el-radio-button border :label="20">以最低运费计算</el-radio-button>
          <el-radio-button border :label="30">以最高运费计算</el-radio-button>
        </el-radio-group>
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info">
            <div slot="title" style="line-height: 30px;">
              <div>
                <strong>叠加：</strong>订单中有多个商品时，将所有商品的运费之和作为订单运费。
              </div>
              <div>
                <strong>以最低运费计算：</strong>订单中有多个商品时，取其中运费最低的商品的运费作为订单运费。
              </div>
              <div>
                <strong>以最高运费计算：</strong>订单中有多个商品时，取其中运费最高商品的运费作为订单运费。
              </div>
            </div>
          </el-alert>
        </div>
      </el-form-item>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingLogisticsBase',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        method: [],
        freight: 10
      },
      rules: {
        method: [{ required: true, message: '配送方式', trigger: 'change' }],
        today_fetch: [{ required: true, message: '当日自提', trigger: 'change' }],
        freight: [{ required: true, message: '运费策略', trigger: 'change' }]
      }
    }
  },
  created () {
    this.loading = true
    get('logistics.base').then(res => {
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
          save('logistics.base', this.form).then(res => {
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

