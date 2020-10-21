<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item prop="template" label-width="0">
        <el-table
          :data="form.template"
        >
          <el-table-column prop="title" label="标题" width="200" align="center" />
          <el-table-column label="模板ID" align="center">
            <template slot-scope="scope">
              <el-input v-model.trim="scope.row.value" clearable placeholder="模板ID" />
            </template>
          </el-table-column>
          <el-table-column prop="detail" label="关键词" align="center" />
          <!-- <el-table-column prop="status" label="状态" width="100" align="center">
            <template slot-scope="scope">
              <el-switch
                v-model="scope.row.status"
                active-color="#13ce66"
                :inactive-value="10"
                :active-value="20"
              />
            </template>
          </el-table-column> -->
        </el-table>
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
  name: 'SettingMessageWxapp',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        driver: 'wxapp',
        template: [
          {
            key: 'ORDER_SHIPMENT',
            value: '',
            title: '订单发货通知',
            detail: '订单编号,商品信息,快递公司,快递单号,收货地址'
          }, {
            key: 'DISTRIBUTION_AUTH',
            value: '',
            title: '分销商入驻审核通知',
            detail: '审核状态,审核时间,申请时间,备注信息'
          }
        ]
      },
      rules: {}
    }
  },
  created () {
    this.loading = true
    get('message.wxapp').then(res => {
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
          save('message.wxapp', this.form).then(res => {
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

