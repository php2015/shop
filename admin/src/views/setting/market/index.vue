<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="分销设置" name="/setting/market" />
      <el-tab-pane :lazy="true" label="邀新奖励" name="/setting/market/invite" />
      <el-tab-pane :lazy="true" label="新人奖励" name="/setting/market/register" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingMarket',
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
