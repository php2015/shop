<template>
  <div
    :style="{'background': params.background, 'padding-top':params.padding_top_bottom + 'px', 'padding-bottom':params.padding_top_bottom + 'px', 'padding-left':params.padding_left_right + 'px', 'padding-right':params.padding_left_right + 'px'}"
  >
    <div style="min-height: 50px; color: #000;" v-html="decodeURIComponent(params.content)" />
  </div>
</template>

<script>
export default {
  name: 'PreviewRich',
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
/*  */
</style>

