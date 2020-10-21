<template>
  <div style="background: #fff; min-height: 100px; display: flex; align-items: center;">
    <div class="coupon">
      <div class="content">
        <div class="money">
          <span>¥</span>100
        </div>
        <div class="co">
          <div class="title">
            无门槛使用
          </div>
        </div>
      </div>
      <div class="split-line" />
    </div>
    <div class="coupon">
      <div class="content">
        <div class="money">
          <span>¥</span>120
        </div>
        <div class="co">
          <div class="title">
            满300.00元可用
          </div>
        </div>
      </div>
      <div class="split-line" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewCoupon',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {}
  },
  computed: {
    params () {
      let data = {}
      this.$store.state.design.params.forEach(item => {
        if (item.id === this.id) {
          data = item.data
        }
      })
      return data
    }
  },
  watch: {},
  created () { },
  methods: {}
}
</script>

<style>
.coupon {
  margin: 0 auto;
  width: 140px;
  height: 80px;
  line-height: 20px;
  display: flex;
  background: #909399;
  background: linear-gradient(-90deg,rgba(250,173,82,1),rgba(254,50,103,1));
}
.coupon .content {
  position: relative;
  flex: 1;
  padding: 10px 15px;
  text-align: center;
}
.coupon .tip {
  position: relative;
  padding:  25px 15px;
  flex: 0 0 50px;
  text-align: center;
}
.coupon .split-line {
  position: relative;
  flex: 0 0 0;
}
.coupon .split-line:before, .split-line:after {
  content: '';
  position: absolute;
  width: 16px;
  height: 8px;
  background: #fff;
  left: -9px;
  z-index: 1;
}
.coupon .content:before, .coupon .content:after{
  content: '';
  position: absolute;
  width: 16px;
  height: 8px;
  background: #fff;
  left: -8px;
  z-index: 1;
}
.coupon .tip:before, .tip:after{
  content: '';
  position: absolute;
  width: 16px;
  height: 8px;
  background:#eee;
  right: -8px;
  z-index: 1;
}
.content:before, .tip:before, .split-line:before{
  border-radius: 0 0 8px 8px;
  top: 0;
}
.content:after, .tip:after, .split-line:after{
  border-radius: 8px 8px 0 0;
  bottom: 0;
}
.coupon .money {
  font-size: 30px;
  color: #eee;
}
.coupon .money span {
  font-size: 15px;
  padding-right: 10px;
}
.coupon .title {
  color: #eee;
  font-size: 12px;
}
.coupon .co {
  padding-top: 5px;
}
</style>

