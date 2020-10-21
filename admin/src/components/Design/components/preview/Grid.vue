<template>
  <div
    :style="{'background': params.background, 'margin':params.margin + 'px'}"
    :class="{'grid-round': params.style=='round'}"
  >
    <!-- 三列 -->
    <div v-if="params.column == 3" class="grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="grid-item3"
      >
        <el-image :style="{width: params.size + 'px', height: params.size + 'px', 'border-radius': '50%'}" :src="item.image" fit="cover">
          <div slot="error" class="grid-image-slot">
            <i class="el-icon-picture" />
          </div>
        </el-image>
        <div class="grid-item-text" :style="{'color': params.color}">{{ item.text }}</div>
      </div>
    </div>

    <!-- 四列 -->
    <div v-if="params.column == 4" class="grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="grid-item4"
      >
        <el-image :style="{width: params.size + 'px', height: params.size + 'px', 'border-radius': '50%'}" :src="item.image" fit="fill">
          <div slot="error" class="grid-image-slot">
            <i class="el-icon-picture" />
          </div>
        </el-image>
        <div class="grid-item-text" :style="{'color': params.color}">{{ item.text }}</div>
      </div>
    </div>

    <!-- 五列 -->
    <div v-if="params.column == 5" class="grid">
      <div
        v-for="(item, index) in params.images"
        :key="index"
        class="grid-item5"
      >
        <el-image :style="{width: params.size + 'px', height: params.size + 'px', 'border-radius': '50%'}" :src="item.image" fit="fill">
          <div slot="error" class="grid-image-slot">
            <i class="el-icon-picture" />
          </div>
        </el-image>
        <div class="grid-item-text" :style="{'color': params.color}">{{ item.text }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewGrid',
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
.grid-round {
  border-radius: 5px
}
.grid-image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 28px;
}
.grid {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  overflow: hidden;
  padding: 10px;
}
.grid-item-text {
  font-size: 14px;
  padding-top: 5px;
  padding-bottom: 12.67px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  text-align: center;
}
.grid-item3 {
  width: 33.33%;
  min-height: 80px;
  text-align: center;
}
.grid-item4 {
  width: 25%;
  min-height: 80px;
  text-align: center;
}
.grid-item5 {
  width: 20%;
  min-height: 80px;
  text-align: center;
}
</style>

