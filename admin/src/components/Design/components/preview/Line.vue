<template>
  <div :style="{ 'padding': (params.padding_top_bottom + 1) + 'px 0px', 'background': params.background }">
    <p class="theme-line" :style="{ 'border-top': '1px ' + params.style + ' ' + params.color }" />
  </div>
  <!-- border-top: 7px dotted rgb(255, 255, 255); -->
</template>

<script>
export default {
  name: 'PreviewLine',
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
.theme-line {
  height: 0;
  width: 100%;
}
.theme-line p {
  margin: 0;
}
</style>

