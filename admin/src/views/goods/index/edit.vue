<template>
  <div>
    <el-tabs v-model="active" tab-position="left" :stretch="true">
      <el-tab-pane label="基础信息" :lazy="true"><edit-index :id="id" /></el-tab-pane>
      <el-tab-pane label="图文描述" :lazy="true"><edit-content :id="id" /></el-tab-pane>
      <el-tab-pane label="销售信息" :lazy="true"><edit-sale :id="id" /></el-tab-pane>
      <el-tab-pane label="物流信息" :lazy="true"><edit-logistics :id="id" /></el-tab-pane>
      <el-tab-pane label="其他信息" :lazy="true"><edit-other :id="id" /></el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import EditIndex from './components/Index'
import EditContent from './components/Content'
import EditSale from './components/Sale'
import EditLogistics from './components/Logistics'
import EditOther from './components/Other'

export default {
  name: 'GoodsEdit',
  components: {
    EditIndex,
    EditContent,
    EditSale,
    EditLogistics,
    EditOther
  },
  data () {
    return {
      active: 0,
      id: null
    }
  },
  created () {
    this.id = parseInt(this.$route.params.id)
    if (!this.id) {
      this.$router.push('404')
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
