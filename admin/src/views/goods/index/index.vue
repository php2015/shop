<template>
  <div class="app-container">
    <el-tabs v-model="active" @tab-click="handleClick">
      <el-tab-pane :label="'销售中(' + count[0] + ')'" name="/goods" />
      <el-tab-pane :label="'仓库中(' + count[1] + ')'" name="/goods/stock" />
      <el-tab-pane :label="'已售罄(' + count[2] + ')'" name="/goods/sold" />
    </el-tabs>
    <router-view :key="active" />
  </div>
</template>

<script>
import { index } from '@/api/goods'

export default {
  name: 'Goods',
  components: {},
  data () {
    return {
      active: this.$route.fullPath,
      count: [0, 0, 0]
    }
  },
  watch: {
    property: {
      immediate: true,
      handler (value) {
        this.getCount()
      }
    }
  },
  methods: {
    getCount () {
      index()
        .then(res => {
          this.count = res.data
        })
        .finally(() => {})
    },
    handleClick (event) {
      this.$router.push(event.name)
    }
  }
}
</script>

<style scoped>
/*  */
</style>
