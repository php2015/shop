<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="150px">
      <el-form-item label="新用户获得" prop="type">
        <el-checkbox-group v-model="form.type">
          <el-checkbox label="points">积分</el-checkbox>
          <el-checkbox label="coupon">优惠卷</el-checkbox>
          <!-- <el-checkbox-button label="balance" disabled>余额</el-checkbox-button> -->
        </el-checkbox-group>
      </el-form-item>
      <section v-if="form.type.indexOf('points') >= 0">
        <el-divider content-position="left">积分</el-divider>
        <el-form-item label="积分" prop="points">
          <el-input-number v-model="form.points" :min="0" label="积分" />
        </el-form-item>
      </section>
      <section v-if="form.type.indexOf('coupon') >= 0">
        <el-divider content-position="left">优惠卷</el-divider>
        <el-form-item label="优惠卷" prop="coupon">
          <el-link icon="el-icon-plus" :underline="false" type="primary" @click="couponSelect">选择优惠卷</el-link>
          <placeholder-coupon :params.sync="form.coupon" @click="couponSelect" />
        </el-form-item>
      </section>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
    <dialog-coupon :visible.sync="visible" :params.sync="form.coupon" @change="couponSelected" />
  </div>
</template>

<script>
import { get, save } from '@/api/setting'
import DialogCoupon from '@/components/Dialog/Coupon'
import PlaceholderCoupon from '@/components/Placeholder/Coupon'

export default {
  name: 'SettingMarketRegister',
  components: {
    DialogCoupon,
    PlaceholderCoupon
  },
  data () {
    const couponValid = (rule, value, callback) => {
      if (value.length === 0) {
        callback(new Error('请选择优惠卷'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      visible: false,
      form: {
        type: [],
        points: 0,
        coupon: []
      },
      rules: {
        points: [{ required: true, message: '请输入新用户可获得积分', trigger: 'blur' }],
        coupon: [{ required: true, trigger: 'change', validator: couponValid }]
      }
    }
  },
  created () {
    this.loading = true
    get('market.register')
      .then(res => {
        if (res.data) {
          this.form.type = res.data.type
          this.form.points = res.data.points
          this.form.coupon = res.data.coupon
        }
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    couponSelect () {
      this.visible = true
    },

    couponSelected (data) {
      this.form.coupon = this.form.coupon.concat(data)
      this.$refs.form.validateField('coupon')
    },

    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.submitLoading = true
          save('market.register', this.form)
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

