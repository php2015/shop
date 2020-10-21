<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="优惠卷名称" prop="coupon_name">
        <el-input v-model.trim="form.coupon_name" placeholder="优惠卷名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="优惠卷公开性" prop="coupon_visible">
        <el-radio-group v-model="form.coupon_visible">
          <el-radio-button :label="10">不公开</el-radio-button>
          <el-radio-button :label="20">公开</el-radio-button>
        </el-radio-group>
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              公开的表示可供用户主动领取，不公开的优惠券可用来设置活动或发卷所需
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-form-item label="发放总量" prop="total">
        <el-input-number v-model="form.total" :min="0" label="发放总量" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              发放数量(限制领取的优惠券数量，0为不限制)
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-divider content-position="left">优惠卷类型</el-divider>
      <el-form-item label="优惠卷类型" prop="coupon_type">
        <el-radio-group v-model="form.coupon_type">
          <el-radio-button :label="10">满减卷</el-radio-button>
          <el-radio-button :label="20">折扣券</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.coupon_type === 10" label="减免金额" prop="amount">
        <el-input-number v-model="form.amount" :precision="2" :min="0" label="减免金额" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              满足最低消费金额后的立减金额
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-form-item v-if="form.coupon_type === 20" label="折扣率" prop="discount">
        <el-input-number v-model="form.discount" :min="1" :max="9.9" label="折扣率" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              折扣率范围(1-9.9，8.5代表8.5折)
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-form-item label="最低消费金额" prop="condition">
        <el-input-number v-model="form.condition" :precision="2" :min="0" label="最低消费金额" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              订单金额需达到该金额才能使用本优惠卷，0为无门槛卷
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-divider content-position="left">到期类型</el-divider>
      <el-form-item label="到期类型" prop="expire_type">
        <el-radio-group v-model="form.expire_type">
          <el-radio-button :label="10">领取后生效</el-radio-button>
          <el-radio-button :label="20">固定时间</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.expire_type === 10" label="有效天数" prop="expire_at">
        <el-input-number v-model="form.expire_at" :min="1" label="有效天数" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              自用户领取之日起N天之内有效
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-form-item v-if="form.expire_type === 20" label="日期区间" prop="between">
        <el-date-picker
          v-model="form.between"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd"
          :picker-options="pickerOptions"
          @change="betweenChange"
        />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              固定日期之间有效
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <el-divider content-position="left">其他</el-divider>
      <el-form-item label="每人限领" prop="receive_limit">
        <el-input-number v-model="form.receive_limit" :min="1" label="每人限领" />
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              每个用户最多可领取该优惠卷的数量
            </div>
          </el-alert>
        </div>
      </el-form-item>
      <!-- <el-form-item label="跳转地址" prop="url">
        <el-input v-model.trim="form.url" placeholder="跳转地址" style="width:80%" />
      </el-form-item>
      <el-form-item label="使用说明" prop="description">
        <el-input v-model="form.description" placeholder="使用说明" type="textarea" style="width:80%" />
      </el-form-item> -->
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/market/coupon/index'

export default {
  name: 'MarketCouponAdd',
  components: {},
  data () {
    const amountValid = (rule, value, callback) => {
      if (this.form.coupon_type === 10 && value === undefined) {
        callback(new Error('请输入减免金额'))
      } else {
        callback()
      }
    }
    const discountValid = (rule, value, callback) => {
      if (this.form.coupon_type === 20 && value === undefined) {
        callback(new Error('请输入折扣率'))
      } else {
        callback()
      }
    }
    const expireAtValid = (rule, value, callback) => {
      if (this.form.expire_type === 10 && value === undefined) {
        callback(new Error('请输入有效天数'))
      } else {
        callback()
      }
    }
    const betweenValid = (rule, value, callback) => {
      if (this.form.expire_type === 20 && !value) {
        callback(new Error('请选择日期区间'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      pickerOptions: {
        shortcuts: [{
          text: '以后一周',
          onClick (picker) {
            const start = new Date()
            const end = new Date()
            end.setTime(start.getTime() + 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '以后一个月',
          onClick (picker) {
            const start = new Date()
            const end = new Date()
            end.setTime(start.getTime() + 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '以后三个月',
          onClick (picker) {
            const start = new Date()
            const end = new Date()
            end.setTime(start.getTime() + 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      },
      form: {
        coupon_name: '',
        coupon_type: 10,
        coupon_visible: 10,
        discount: 0,
        amount: 0,
        condition: 0,
        total: 0,
        expire_type: 10,
        begin_at: '',
        end_at: '',
        expire_at: 30,
        status: 20,
        receive_limit: 1,
        between: null
      },
      rules: {
        coupon_name: [{ required: true, message: '请输入优惠卷名称', trigger: 'blur' }],
        total: [{ required: true, message: '请输入发放总量', trigger: 'blur' }],
        coupon_type: [{ required: true, message: '请选择优惠卷类型', trigger: 'change' }],
        coupon_visible: [{ required: true, message: '请选择优惠卷公开性', trigger: 'change' }],
        amount: [{ required: true, trigger: 'blur', validator: amountValid }],
        discount: [{ required: true, trigger: 'blur', validator: discountValid }],
        condition: [{ required: true, message: '请输入最低消费金额', trigger: 'blur' }],
        expire_type: [{ required: true, message: '请选择到期类型', trigger: 'change' }],
        expire_at: [{ required: true, trigger: 'blur', validator: expireAtValid }],
        between: [{ required: true, trigger: 'change', validator: betweenValid }],
        receive_limit: [{ required: true, message: '请输入领取上限', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    add()
      .then(res => {
        this.category = res.data.category
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    betweenChange (event) {
      this.form.begin_at = event[0]
      this.form.end_at = event[1]
    },

    handleSubmit () {
      this.submitLoading = true
      this.$refs.form.validate((valid) => {
        if (valid) {
          doAdd(this.form).then(res => {
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

