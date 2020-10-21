<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="优惠卷名称" prop="coupon_name">
        <el-input v-model.trim="form.coupon_name" placeholder="优惠卷名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="接收群体" prop="group">
        <el-radio-group v-model="form.group">
          <el-radio-button :label="10">选择用户</el-radio-button>
          <el-radio-button :label="20">新用户</el-radio-button>
          <el-radio-button :label="30">老用户</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-show="form.group == 10" prop="user">
        <placeholder-image :width="50" :height="50" :params.sync="form.user" @click="visible = true" />
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
        <el-tooltip>
          <div slot="content">立减金额</div>
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-form-item v-if="form.coupon_type === 20" label="折扣率" prop="discount">
        <el-input-number v-model="form.discount" :min="0" label="折扣率" />
        <el-tooltip>
          <div slot="content">折扣率范围(0-10，8.5代表8.5折)</div>
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-form-item label="最低消费金额" prop="condition">
        <el-input-number v-model="form.condition" :precision="2" :min="0" label="最低消费金额" />
        <el-tooltip>
          <div slot="content">
            订单金额需达到该金额才能使用本优惠卷
            <br>0 为无门槛卷
          </div>
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-divider content-position="left">到期类型</el-divider>
      <el-form-item label="到期类型" prop="expire_type">
        <el-radio-group v-model="form.expire_type">
          <el-radio-button :label="10">领取后生效</el-radio-button>
          <el-radio-button :label="20">固定时间</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.expire_type === 10" label="有效天数" prop="expire_at">
        <el-input-number v-model="form.expire_at" :min="30" label="有效天数" />
        <el-tooltip>
          <div slot="content">自用户领取之日起多少天之内有效</div>
          <i class="el-icon-question" />
        </el-tooltip>
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
        <el-tooltip>
          <div slot="content">固定日期之间有效</div>
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
    <dialog-user :visible.sync="visible" :params.sync="form.user" @change="userSelected" />
  </div>
</template>

<script>
import { doIssue } from '@/api/market/coupon/index'
import PlaceholderImage from '@/components/Placeholder/Image'
import DialogUser from '@/components/Dialog/User'

export default {
  name: 'MarketCouponIssue',
  components: {
    PlaceholderImage,
    DialogUser
  },
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
    const userValid = (rule, value, callback) => {
      if (this.form.group === 10 && value.length === 0) {
        callback(new Error('请选择用户'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      visible: false,
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
        group: 10,
        user: [],
        coupon_type: 10,
        discount: 9,
        amount: 1,
        condition: 0,
        expire_type: 10,
        begin_at: '',
        end_at: '',
        expire_at: 0,
        receive_limit: 1,
        status: 20,
        description: '',
        url: '',
        between: null
      },
      rules: {
        coupon_name: [{ required: true, message: '请输入优惠卷名称', trigger: 'blur' }],
        group: [{ required: true, message: '接收群体', trigger: 'change' }],
        coupon_type: [{ required: true, message: '请选择优惠卷类型', trigger: 'change' }],
        amount: [{ required: true, trigger: 'blur', validator: amountValid }],
        discount: [{ required: true, trigger: 'blur', validator: discountValid }],
        condition: [{ required: true, message: '请输入最低消费金额', trigger: 'blur' }],
        expire_type: [{ required: true, message: '请选择到期类型', trigger: 'change' }],
        expire_at: [{ required: true, trigger: 'blur', validator: expireAtValid }],
        between: [{ required: true, trigger: 'change', validator: betweenValid }],
        user: [{ required: true, trigger: 'change', validator: userValid }]
      }
    }
  },
  computed: {},
  watch: {},
  created () { },
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
    },

    betweenChange (event) {
      this.form.begin_at = event[0]
      this.form.end_at = event[1]
    },

    userSelected (data) {
      this.form.user = this.form.user.concat(data)
    }
  }
}
</script>

<style>
/*  */
</style>
