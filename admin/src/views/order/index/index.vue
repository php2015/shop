<template>
  <div class="app-container">
    <el-tabs v-model="active" @tab-click="handleClick">
      <el-tab-pane label="全部订单" name="/order" />
      <el-tab-pane label="快递发货" name="/order/express" />
      <el-tab-pane label="同城配送" name="/order/local" />
      <el-tab-pane label="上门自提" name="/order/fetch" />
    </el-tabs>
    <router-view :key="active" />
  </div>
</template>

<script>
export default {
  name: 'Order',
  components: {},
  data () {
    return {
      active: this.$route.fullPath
    }
  },
  methods: {
    handleClick (event) {
      this.$router.push(event.name)
    }
  }
}
</script>

<style scoped>
/*  */
</style>
