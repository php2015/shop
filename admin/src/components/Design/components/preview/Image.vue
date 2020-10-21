<template>
  <div :style="{'background':params.background}">
    <div
      v-for="(item, index) in params.images"
      :key="index"
      :style="{'padding-top':params.padding_top_bottom + 'px', 'padding-bottom':params.padding_top_bottom + 'px', 'padding-left':params.padding_left_right + 'px', 'padding-right':params.padding_left_right + 'px'}"
    >
      <el-image style="width: 100%; display: block;" :src="item.image" fit="fill">
        <div slot="error" class="images-slot">
          <i class="el-icon-picture" />
        </div>
      </el-image>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewImage',
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
.images-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 50px;
}
.image-round {
  border-radius: 5px
}
</style>
