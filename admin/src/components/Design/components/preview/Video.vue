<template>
  <div :style="{'background':params.background}">
    <div
      :style="{'padding-top':params.padding_top_bottom + 'px', 'padding-bottom':params.padding_top_bottom + 'px', 'padding-left':params.padding_left_right + 'px', 'padding-right':params.padding_left_right + 'px'}"
    >
      <el-image
        v-if="!(params.video && params.video.link)"
        :src="params.video && params.video.link"
        :style="{'width': '100%', 'height': params.height + 'px', 'display': 'block'}"
        fit="fill"
      >
        <div slot="error" class="video-image-slot">
          <i class="el-icon-video-camera-solid" />
        </div>
      </el-image>
      <video v-else :src="params.video.link" width="100%" controls :poster="params.video.poster" :height="params.height" :autoplay="params.autoplay" style="display: block" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewVideo',
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
.video-image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 80px;
}
</style>
