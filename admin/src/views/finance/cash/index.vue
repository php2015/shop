<template>
  <div>
    <el-tabs tab-position="left" :stretch="true">
      <el-tab-pane label="申请中"><List /></el-tab-pane>
      <el-tab-pane label="已通过" :lazy="true"><List :status="1" /></el-tab-pane>
      <el-tab-pane label="已拒绝" :lazy="true"><List :status="2" /></el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import List from './components/List'

export default {
  name: 'FinanceCash',
  components: { List },
  methods: {
    tabClick (event) {
      sessionStorage.setItem(this.$route.path + '/page', 1)
    }
  }
}
</script>

<style scoped>
/*  */
</style>
