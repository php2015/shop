<template>
  <div
    :style="{
      'width': '100%',
      'height': '200px',
      'min-height': '200px',
      'line-height': '200px',
      'background-image': 'url(' + (params.background_image ? params.background_image : require('@/assets/image/design/mine.png')) + ')',
      'background-repeat':'no-repeat',
      'background-size': 'cover',
      'background-position':'center center',
      'cursor': 'pointer'
    }"
  >
    <div class="mine-header-left">
      <div>
        <el-avatar :size="58" :src="avatar" />
      </div>
      <div class="nickname" :style="{'color': params.color}">
        用户昵称
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewMine',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      avatar: require('@/assets/image/design/avatar.jpg')
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
.mine-header-left {
  display: flex;
  align-items: center;
  /* justify-content: flex-start; */
  height: 100%;
  position: relative;
  padding-left: 30px;
  padding-top: 50px;
  font-weight: bold;
  font-size: 20px;
}
.mine-header-left .nickname {
  position: relative;
  top: -20px;
  padding-left: 5px;
}
</style>

