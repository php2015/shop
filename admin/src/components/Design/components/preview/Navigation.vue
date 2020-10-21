<template>
  <div
    class="navigation-bar"
    :style="{'background' : params.app_skin, 'color' : params.navigation_bar_text_style}"
  >
    <div class="navigation-bar-title">{{ params.app_name }}</div>
    <div style="position: absolute; right: 20px; bottom: 20px;">
      <i class="el-icon-more" style="font-size: 30px" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewNavigation',
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
.navigation-bar {
  position: relative;
  width: 100%;
  height: 66px;
  text-align: center;
  background: #fff;
  z-index: 999;
}
.navigation-bar-title {
  padding-top: 20px;
}
</style>

