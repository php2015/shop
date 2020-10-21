<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="短信" name="/setting/message" />
      <el-tab-pane :lazy="true" label="公众号模板消息" name="/setting/message/wx" />
      <el-tab-pane :lazy="true" label="小程序模板消息" name="/setting/message/wxapp" />
    </el-tabs>
    <router-view style="width: 85%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingSms',
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
