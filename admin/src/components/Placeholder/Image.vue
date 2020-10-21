<template>
  <div>
    <ul class="el-upload-list el-upload-list--picture-card">
      <li v-for="item in params" :key="item.id" tabindex="0" class="el-upload-list__item is-success" :style="'width:'+width+'px; height:'+height+'px;'">
        <img
          :src="item.image"
          class="el-upload-list__item-thumbnail"
        >
        <span class="el-upload-list__item-actions" @click="remove(item.id)">
          <span class="el-upload-list__item-delete">
            <i class="el-icon-delete" />
          </span>
        </span>
      </li>
    </ul>
    <div
      v-if="radio && params.length == 0"
      class="el-upload el-upload--picture-card"
      :style="'width:'+width+'px; height:'+height+'px; line-height:'+height+'px'"
      @click="click"
    >
      <i class="el-icon-plus" style="font-size: 20px" />
    </div>
    <div
      v-if="!radio"
      class="el-upload el-upload--picture-card"
      :style="'width:'+width+'px; height:'+height+'px; line-height:'+height+'px'"
      @click="click"
    >
      <i class="el-icon-plus" style="font-size: 20px" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlaceholderImage',
  components: {},
  mixins: [],
  props: {
    params: {
      type: Array,
      default: () => []
    },
    height: {
      type: Number,
      default: 0
    },
    width: {
      type: Number,
      default: 1
    },
    radio: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {

    }
  },
  computed: {},
  watch: {},
  created () { },
  methods: {
    click () {
      this.$emit('click')
    },

    remove (id) {
      this.params.forEach((item, index) => {
        if (item.id === id) {
          this.params.splice(index, 1)
        }
      })
    }
  }
}
</script>

<style>
.image-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.image-uploader .el-upload:hover {
  border-color: #409eff;
}
.image-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 146px;
  height: 146px;
  line-height: 146px;
  text-align: center;
}
</style>
