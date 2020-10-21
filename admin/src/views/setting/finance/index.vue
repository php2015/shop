<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" :stretch="true" @tab-click="handleClick">
      <el-tab-pane :lazy="true" label="提现设置" name="/setting/finance" />
      <!-- <el-tab-pane :lazy="true" label="充值设置" name="/setting/finance/deposit" /> -->
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'SettingFinance',
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
