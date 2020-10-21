<template>
  <div style="display: flex;">
    <el-tabs v-model="active" tab-position="left" @tab-click="tabClick">
      <el-tab-pane :lazy="true" label="打标签" :name="`/user/edit/${id}`" />
      <el-tab-pane :lazy="true" label="调积分" :name="`/user/edit/points/${id}`" />
    </el-tabs>
    <router-view style="width: 90%;" />
  </div>
</template>

<script>
export default {
  name: 'UserEdit',
  components: {},
  data () {
    return {
      active: this.$route.path,
      id: null
    }
  },
  created () {
    this.id = this.$route.params.id
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
