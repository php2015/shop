<template>
  <div style="position: relative;" :style="{padding: params.style=='plane' ? params.padding+'px' : '0px'}">
    <el-carousel
      :height="params ? params.height + 'px' : '200px'"
      :autoplay="params.autoplay"
      :interval="params.interval"
      :indicator-position="params.indicatorDots ? '' : 'none'"
      arrow="never"
    >
      <el-carousel-item v-for="(item, index) in params.images" :key="index">
        <el-image
          style="width: 100%; height: 100%;"
          :src="item.image"
          fit="cover"
        >
          <div slot="error" class="swiper-image-slot">
            <i class="el-icon-picture" />
          </div>
        </el-image>
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
export default {
  name: 'PreviewSwiper',
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
  created () {},
  methods: {}
}
</script>

<style>
.swiper-image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 100px;
}
</style>
