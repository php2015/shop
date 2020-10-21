<template>
  <div>
    <el-image style="width: 100%;" :src="image" fit="fill" />
  </div>
</template>

<script>
export default {
  name: 'PreviewFixd',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      image: require('@/assets/image/design/fixd.png')
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
