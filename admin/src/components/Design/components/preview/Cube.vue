<template>
  <div style="margin: 0; padding: 0;">
    <!-- 1左2右 -->
    <div v-if="params.layout == 0" class="display" :style="{'background':params.background}">
      <div class="display-left" :style="{'padding':params.padding + 'px'}">
        <el-image
          :class="{'cube-round': params.style=='round'}"
          style="width: 100%; height: 100%;"
          :src="params.images[0] && params.images[0].image"
          fit="fill"
        >
          <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
            <i class="el-icon-picture" />
          </div>
        </el-image>
      </div>
      <div class="display-right">
        <div class="display-right1" :style="{'padding':params.padding + 'px'}">
          <el-image
            :class="{'cube-round': params.style=='round'}"
            style="width: 100%; height: 100%;"
            :src="params.images[1] && params.images[1].image"
            fit="fill"
          >
            <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
              <i class="el-icon-picture" />
            </div>
          </el-image>
        </div>
        <div class="display-right2" :style="{'padding':params.padding + 'px'}">
          <el-image
            :class="{'cube-round': params.style=='round'}"
            style="width: 100%; height: 100%;"
            :src="params.images[2] && params.images[2].image"
            fit="fill"
          >
            <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
              <i class="el-icon-picture" />
            </div>
          </el-image>
        </div>
      </div>
    </div>

    <!-- 1上2下 -->
    <div v-if="params.layout == 1" :style="{'background':params.background}">
      <div :style="{'width': '100%', 'padding':params.padding + 'px'}">
        <el-image
          style="width: 100%; height: 100%; display: block;"
          :class="{'cube-round': params.style=='round'}"
          :src="params.images[0] && params.images[0].image"
          fit="fill"
        >
          <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
            <i class="el-icon-picture" />
          </div>
        </el-image>
      </div>
      <div style="display: flex;">
        <div :style="{'width': '50%', 'padding':params.padding + 'px'}">
          <el-image
            style="width: 100%; height: 100%;"
            :class="{'cube-round': params.style=='round'}"
            :src="params.images[1] && params.images[1].image"
            fit="fill"
          >
            <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
              <i class="el-icon-picture" />
            </div>
          </el-image>
        </div>
        <div :style="{'width': '50%', 'padding':params.padding + 'px'}">
          <el-image
            style="width: 100%; height: 100%;"
            :class="{'cube-round': params.style=='round'}"
            :src="params.images[2] && params.images[2].image"
            fit="fill"
          >
            <div slot="error" class="cube-images-slot" :class="{'cube-round': params.style=='round'}">
              <i class="el-icon-picture" />
            </div>
          </el-image>
        </div>
      </div>
    </div>

    <!-- 两列 -->
    <div v-if="params.layout == 2" :style="{'background':params.background}" class="cube-grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="cube-grid-item-2"
      >
        <img
          :src="item.image ? item.image : squareImage"
          :style="{'width':'100%', 'padding':params.padding + 'px'}"
          :class="{'cube-round': params.style=='round'}"
        >
      </div>
    </div>

    <!-- 三列 -->
    <div v-if="params.layout == 3" :style="{'background':params.background}" class="cube-grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="cube-grid-item-3"
      >
        <img
          :src="item.image ? item.image : squareImage"
          :style="{'width':'100%', 'padding':params.padding + 'px'}"
          :class="{'cube-round': params.style=='round'}"
        >
      </div>
    </div>

    <!-- 四列 -->
    <div v-if="params.layout == 4" :style="{'background':params.background}" class="cube-grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="cube-grid-item-4"
      >
        <img
          :src="item.image ? item.image : squareImage"
          :style="{'width':'100%', 'padding':params.padding + 'px'}"
          :class="{'cube-round': params.style=='round'}"
        >
      </div>
    </div>

    <!-- 横向滚动 -->
    <div v-if="params.layout == 5" :style="{'background':params.background}">
      <div class="lateral-sliding">
        <div v-for="(item, index) in params.images" :key="index" class="lateral-sliding-item" :style="{'padding': params.padding + 'px'}">
          <!-- <img
            :src="item.image ? item.image : squareImage"
            :style="{'width':'100%', 'height': '100%'}"
          > -->
          <div class="each-img">
            <img
              :src="item.image ? item.image : squareImage"
              :style="{'width':'100%', 'height': '100%'}"
              :class="{'cube-round': params.style=='round'}"
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewCube',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      rectangleImage: require('@/assets/image/design/rectangle.png'),
      squareImage: require('@/assets/image/design/square.png')
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
.cube-images-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 50px;
}
.cube-round {
  border-radius: 15px
}
.display img {
  width: 100%;
  height: 100%;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  vertical-align: middle;
  border: 0;
}
.display {
  height: 0;
  width: 100%;
  margin: 0;
  padding-bottom: 50%;
  position: relative;
}
.display-left {
  width: 50%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}
.display-right {
  width: 50%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 50%;
}
.display-right1 {
  width: 100%;
  height: 50%;
  position: absolute;
  top: 0;
  left: 0;
}
.display-right2 {
  width: 100%;
  height: 50%;
  position: absolute;
  top: 50%;
  left: 0;
}
.cube-grid {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  overflow: hidden;
}
.cube-grid-item-2 {
  width: 50%;
  height: 0;
  padding-bottom: 50%;
}
.cube-grid-item-3 {
  width: 33.33%;
	height: 0;
  padding-bottom: 33.33%;
  overflow: hidden;
}
.cube-grid-item-4 {
  width: 25%;
	height: 0;
  padding-bottom: 25%;
  overflow: hidden;
}
/* .grid-item img {
  width: 100%;
  height: 100%;
} */
.lateral-sliding {
  display: flex;
  overflow-y: hidden;
  overflow-x: scroll;
}
.lateral-sliding-item {
  display: flex;
  /* margin-right: 8px; */
}
.each-img {
  width: 150px;
  height: 150px;
}
</style>

