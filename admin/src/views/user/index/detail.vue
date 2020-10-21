<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" @tab-click="tabClick">
      <el-tab-pane :lazy="true" label="基础信息" :name="`/user/detail/${id}`" />
      <el-tab-pane :lazy="true" label="订单信息" :name="`/user/detail/order/${id}`" />
      <el-tab-pane :lazy="true" label="佣金信息" :name="`/user/detail/bonus/${id}`" />
      <el-tab-pane :lazy="true" label="积分信息" :name="`/user/detail/points/${id}`" />
      <el-tab-pane :lazy="true" label="收藏信息" :name="`/user/detail/like/${id}`" />
      <el-tab-pane :lazy="true" label="购物车信息" :name="`/user/detail/cart/${id}`" />
      <el-tab-pane :lazy="true" label="优惠卷信息" :name="`/user/detail/coupon/${id}`" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'UserDetail',
  components: {},
  data () {
    return {
      active: this.$route.path,
      id: null
    }
  },
  created () {
    this.id = this.$route.params.id
    if (!this.id) {
      this.$router.push('404')
    }
  },
  methods: {
    tabClick (event) {
      this.$router.push(event.name)
    }
  }
}
</script>

<style scoped>
/*  */
</style>
