<template>
  <div
    class="diy-notice dis-flex"
    style="display: flex; align-items: center"
    :style="{'background': params.background, 'padding-top':params.padding_top_bottom + 'px', 'padding-bottom':params.padding_top_bottom + 'px'}"
  >
    <div>
      <img :src="params.icon" style="height: 20px; margin-top: 5px;">
    </div>
    <div class="notice__text flex-box am-text-truncate">
      <span class="content" :style="{'color': params.color}">{{ params.content }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewNotice',
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
.diy-notice {
    padding: 4px 10px;
    line-height: 26px;
}
.dis-flex {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
}
.diy-notice .notice__text {
    padding-left: 5px;
}
.flex-box {
    flex: 1;
}
.am-ellipsis, .am-text-truncate {
    word-wrap: normal;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.content {
  font-size: 12px;
}
</style>

