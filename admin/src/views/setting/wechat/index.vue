<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="公众号设置" name="/setting/wechat" />
      <el-tab-pane :lazy="true" label="小程序设置" name="/setting/wechat/wxapp" />
      <el-tab-pane :lazy="true" label="支付设置" name="/setting/wechat/payment" />
      <el-tab-pane :lazy="true" label="腾讯位置服务" name="/setting/wechat/location" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingWechat',
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
