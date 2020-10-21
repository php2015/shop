<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="tabClick">
      <el-tab-pane label="基本信息" :lazy="true" name="/profile" />
      <el-tab-pane label="修改密码" :lazy="true" name="/profile/password" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'Profile',
  components: {},
  data () {
    return {
      active: this.$route.path
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
