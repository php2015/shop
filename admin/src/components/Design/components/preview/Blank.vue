<template>
  <div>
    <div :style="{'width': '100%', 'min-height': params.height + 'px', 'background': params.background}" />
    <!-- <div style="width: 100%; min-height: 50px; background: #fff;" /> -->
  </div>
</template>

<script>
export default {
  name: 'PreviewBlank',
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

