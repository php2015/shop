<template>
  <div
    :style="{'background': params.background, 'padding-top':params.padding_top_bottom + 'px', 'padding-bottom':params.padding_top_bottom + 'px', 'padding-left':params.padding_left_right + 'px', 'padding-right':params.padding_left_right + 'px'}"
  >
    <div class="diy-search" :style="{'background': params.background}">
      <div :class="'inner ' + params.style">
        <div class="search-input" style="text-align: left;">
          <i class="el-icon-search" />
          <span>{{ params.text }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewSearch',
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
.diy-search {
    background: #efefef;
    padding: 10px 10px;
}
.diy-search .inner {
    height: 30px;
    background: #fff;
    overflow: hidden;
}
.diy-search .inner .search-input {
    height: 30px;
    line-height: 30px;
    color: #999999;
    padding: 0 10px;
}
.diy-search .inner.round {
    border-radius: 30px;
}
.diy-search .inner.radius {
    border-radius: 5px;
}
</style>

