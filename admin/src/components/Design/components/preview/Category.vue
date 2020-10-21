<template>
  <div>
    <img :src="require('@/assets/image/design/category_' + params.layout + '.png')" style="width: 100%">
  </div>
</template>

<script>
export default {
  name: 'PreviewCategory',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      image: require('@/assets/image/design/category_10.png')
    }
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

