<template>
  <div
    :style="{
      'width': '100%',
      'height': params.height + 'px',
      'min-height': params.height + 'px',
      'line-height': params.height + 'px',
      'background-color': params.background,
      'background-image': 'url(' + params.background_image + ')',
      'background-repeat':'no-repeat',
      'background-size': 'cover',
      'background-position':'center center'
    }"
  >
    <div style="display: flex;">
      <div
        :style="{
          'width': '100%',
          'padding-left': '5px',
          'text-align': params.text_align,
          'color': params.color,
          'font-weight': params.font_weight,
          'font-size': fontSize + 'px'
        }"
      >
        {{ params.content }}
      </div>
      <div v-if="params.link_tips == 'arrow'" style="position: absolute; right: 5px;" :style="{color: params.color}">
        <i class="el-icon-arrow-right" />
      </div>
      <div v-if="params.link_tips == 'more'" style="position: absolute; right: 5px;" :style="{color: params.color}">
        <span style="font-size: 12px;">更多</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewText',
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
    },
    fontSize () {
      if (this.params.font_size === 'large') {
        return 18
      } else if (this.params.font_size === 'medium') {
        return 16
      }
      return 14
    }
  },
  watch: {},
  created () { },
  methods: {}
}
</script>

<style>
/*  */
</style>

