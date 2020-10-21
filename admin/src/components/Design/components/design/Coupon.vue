<template>
  <div class="app-container">
    <div class="design-title">优惠卷</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="120px">
      <el-form-item label="优惠卷" prop="coupon">
        <el-link icon="el-icon-plus" :underline="false" type="primary" @click="visible = true">选择优惠卷</el-link>
        <placeholder-coupon :params.sync="form.coupon" />
      </el-form-item>
      <el-form-item label="隐藏已抢完券" prop="hide">
        <el-radio-group v-model="form.hide" size="mini">
          <el-radio-button border :label="10">不隐藏</el-radio-button>
          <el-radio-button border :label="20">隐藏</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <dialog-coupon :visible.sync="visible" :params.sync="form.coupon" @change="couponSelected" />
  </div>
</template>

<script>
import DialogCoupon from '@/components/Dialog/Coupon'
import PlaceholderCoupon from '@/components/Placeholder/Coupon'

export default {
  name: 'DesignCoupon',
  components: {
    DialogCoupon,
    PlaceholderCoupon
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      visible: false,
      form: {
        coupon: [],
        hide: 10
      },
      rules: {}
    }
  },
  computed: {
    params: {
      get () {
        return this.$store.state.design.params
      },
      set (value) {
        this.$store.commit('design/SET_PARAMS', value)
      }
    }
  },
  watch: {
    form: {
      handler (value) {
        this.handleSubmit(value)
      },
      deep: true
    }
  },
  created () {
    this.params.forEach(item => {
      if (item.id === this.id) {
        if (JSON.stringify(item.data) === '{}') {
          this.handleSubmit(this.form)
        } else {
          this.form = item.data
        }
      }
    })
  },
  methods: {
    couponSelected (data) {
      this.form.coupon = this.form.coupon.concat(data)
      this.$refs.form.validateField('coupon')
    },

    handleSubmit (value) {
      this.params.forEach((item, index) => {
        if (item.id === this.id) {
          this.params[index].data = value
        }
      })
    }
  }
}
</script>

<style>
.title {
  font-weight: bold;
  padding: 10px;
}
</style>
