<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="基础设置" name="/setting/logistics" />
      <el-tab-pane :lazy="true" label="包邮设置" name="/setting/logistics/free" />
      <el-tab-pane :lazy="true" label="快递公司" name="/setting/logistics/company" />
      <el-tab-pane :lazy="true" label="快递发货" name="/setting/logistics/express" />
      <el-tab-pane :lazy="true" label="同城配送" name="/setting/logistics/local" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingLogistics',
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
