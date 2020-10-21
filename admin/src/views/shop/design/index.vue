<template>
  <div v-loading="loading">
    <el-menu :default-active="active" class="el-menu-demo" mode="horizontal" @select="select">
      <el-menu-item index="index">主页</el-menu-item>
      <el-menu-item index="category">分类</el-menu-item>
      <el-menu-item index="cart">购物车</el-menu-item>
      <el-menu-item index="mine">我的</el-menu-item>
    </el-menu>
    <design :key="active" @submit="handleSubmit" />
  </div>
</template>

<script>
import Design from '@/components/Design'
import { fetch, doSave } from '@/api/shop/design'

export default {
  name: 'ShopDesign',
  components: {
    Design
  },
  data () {
    return {
      loading: true,
      active: 'index'
    }
  },
  watch: {},
  created () {
    this.design(this.active)
  },
  methods: {
    select (key) {
      this.active = key
      this.design(key)
    },

    design (page) {
      this.loading = true
      fetch(page).then(res => {
        const { data } = res
        this.$store.dispatch('design/init', {
          params: data,
          page: page
        })
      })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit (params) {
      this.loading = true
      doSave(JSON.stringify(params), this.active).then(res => {
        this.$message({
          message: res.msg,
          type: 'success'
        })
      })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<style scoped>
/*  */
</style>
