<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="基础设置" name="/setting/app" />
      <el-tab-pane :lazy="true" label="订单设置" name="/setting/app/order" />
      <el-tab-pane :lazy="true" label="积分设置" name="/setting/app/points" />
      <el-tab-pane :lazy="true" label="邀请设置" name="/setting/app/invite" />
      <el-tab-pane :lazy="true" label="反馈分类" name="/setting/app/feedback" />
      <el-tab-pane :lazy="true" label="规则协议" name="/setting/app/rule" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingApp',
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
