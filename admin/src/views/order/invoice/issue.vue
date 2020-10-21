<template>
  <div v-loading="loading" class="app-container">
    <div
      class="el-table el-table--border"
      style="width: 100%;"
    >
      <div class="el-table__header-wrapper">
        <table
          cellspacing="0"
          cellpadding="0"
          border="0"
          class="el-table__header"
          style="width: 100%;"
        >
          <thead class="has-gutter">
            <tr class>
              <th class="is-center">
                <div class="cell">商品总额</div>
              </th>
              <th class="is-center">
                <div class="cell">运费金额</div>
              </th>
              <th class="is-center">
                <div class="cell">优惠金额</div>
              </th>
              <th class="is-center">
                <div class="cell">实际支付金额</div>
              </th>
            </tr>
          </thead>
          <td class="is-center">
            ￥{{ form.order && form.order.goods_price }}
          </td>
          <td class="is-center">
            ￥{{ form.order && form.order.logistics_fee }}
          </td>
          <td class="is-center">
            ￥{{ form.order && form.order.discount_price }}
          </td>
          <td class="is-center">
            ￥{{ form.order && form.order.payment_price }}
          </td>
        </table>
      </div>
    </div>
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%" style="padding: 20px">
      <el-form-item label="发票代码" prop="code">
        <el-input v-model.trim="form.code" clearable placeholder="发票代码" style="width:80%" />
      </el-form-item>
      <el-form-item label="税金" prop="tax">
        <el-input-number v-model="form.tax" :min="0" :precision="2" style="width: 200px;" />
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button :label="10">未开票</el-radio-button>
          <el-radio-button :label="20">已开票</el-radio-button>
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
import { issue, doIssue } from '@/api/order/invoice'

export default {
  name: 'OrderDetail',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      detail: {},
      form: {
        id: null,
        code: '',
        tax: 0,
        status: 10
      },
      rules: {}
    }
  },
  computed: {},
  created () {
    this.loading = true
    issue(this.$route.params.id)
      .then(res => {
        this.form = res.data
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
          doIssue(this.form).then(res => {
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

