<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="基础设置" name="/setting/system" />
      <el-tab-pane :lazy="true" label="安全设置" name="/setting/system/security" />
      <el-tab-pane :lazy="true" label="存储设置" name="/setting/system/storage" />
      <el-tab-pane :lazy="true" label="缓存清理" name="/setting/system/cache" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingSystem',
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
