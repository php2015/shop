<template>
  <div
    :style="{'background': '#fff', 'margin':params.margin + 'px'}"
    :class="{'cell-round': params.style=='round'}"
  >
    <div v-for="(item, index) in params.images" :key="index" class="cell-group" :style="{'color': params.color}">
      <div class="cell-left">
        <div>
          <img
            v-if="item.image"
            class="cell-image"
            :src="item.image"
          >
        </div>
        <div class="cell-title">{{ item.text }}</div>
      </div>
      <div>
        <i class="el-icon-arrow-right" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewCell',
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
.cell-round {
  border-radius: 5px
}
.cell-group {
  display: flex;
  justify-content: space-between;
  height: 50px;
  line-height: 50px;
  border-bottom: 1px solid #efefef;
}
.cell-left {
  display: flex;
}
.cell-left div {
  /* line-height: 65px; */
  padding-left: 10px;
}
.cell-image {
  width: 28px;
  height: 28px;
  position: relative;
  top: 8px;
}
.cell-title {
  padding-left: 10px;
}
.image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #f5f7fa;
  color: #909399;
  font-size: 100px;
}
</style>

