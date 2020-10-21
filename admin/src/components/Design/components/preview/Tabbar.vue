<template>
  <div class="tabbar" :style="{ 'background': params.background }">
    <div v-for="(item, index) in params.item" :key="index" class="tabbar-item">
      <div class="tabbar-item-icon">
        <el-image style="width: 28px; height: 28px;" :src="item.image_active" fit="fit">
          <div slot="error" class="tabbar-image-slot">
            <i class="el-icon-picture" />
          </div>
        </el-image>
      </div>
      <div class="tabbar-item-text" :style="{color: params.color}">{{ item.text }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewTabbar',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {}
  },
  computed: {
    params () {
      let data = {}
      this.$store.state.design.params.forEach(item => {
        if (item.id === this.id) {
          data = item.data
        }
      })
      return data
    }
  },
  watch: {},
  created () { },
  methods: {}
}
</script>

<style>
.tabbar {
  position: absolute;
  left: 0;
  bottom: 0;
  display: flex;
  justify-content: space-around;
  min-height: 50px;
  width: 100%;
  background: #fff;
  padding: 5px;
  z-index: 999;
}
.tabbar-item {
  width: 100%;
  text-align: center;
}
.tabbar-item-icon img {
  height: 28px;
  width: 28px;
}
.tabbar-item-text {
  font-size: 12px;
}
.tabbar-image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #f5f7fa;
  color: #909399;
  font-size: 28px;
}
</style>

