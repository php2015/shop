<template>
  <div>
    <el-upload
      ref="upload"
      v-loading="loading"
      class="image-uploader"
      :auto-upload="true"
      :show-file-list="false"
      :accept="accept"
      :headers="headers"
      :action="action"
      :on-success="onSuccess"
      :on-error="onError"
      :on-progress="onProgress"
      :before-upload="beforeUpload"
    >
      <section v-if="file != ''">
        <video v-if="accept.indexOf('video/mp4') >= 0" :src="file" :width="width" :height="height" />
        <img v-else :src="file" class="image" :style="'width:'+width+'px; height:'+height+'px;'">
      </section>
      <section v-else>
        <i class="el-icon-plus image-uploader-icon" :style="'width:'+width+'px; height:'+height+'px; line-height:'+height+'px;'" />
      </section>
    </el-upload>
  </div>
</template>

<script>
import { getToken } from '@/utils/user'

export default {
  name: 'UploadSingle',
  components: {},
  mixins: [],
  props: {
    headers: {
      type: Object,
      default: () => ({
        'X-Token': getToken()
      })
    },
    accept: {
      type: String,
      default: 'image/jpeg, image/png, image/gif'
    },
    action: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    size: {
      type: Number,
      default: 5
    },
    width: {
      type: Number,
      default: 146
    },
    height: {
      type: Number,
      default: 146
    },
    index: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      loading: false,
      file: ''
    }
  },
  computed: {},
  watch: {
    url: {
      immediate: true,
      handler (value) {
        this.file = value
      }
    }
  },
  created () { },
  methods: {
    onProgress (event, file) {
      this.loading = true
    },

    onSuccess (res, file) {
      this.loading = false
      if (res.code === 0) {
        file.index = this.index
        this.$emit('onSuccess', file)
        this.file = URL.createObjectURL(file.raw)
      } else {
        this.$message.error(res.msg)
      }
    },

    onError (res) {
      console.log('Error:', res)
      this.loading = false
    },

    beforeUpload (file) {
      const size = file.size / 1024 / 1024 < this.size
      if (!size) {
        this.$message.error('图片大小不能超过 ' + this.size + 'MB!')
        return false
      }
      if (this.accept.indexOf(file.type) < 0) {
        this.$message.error('图片格式错误!')
        return false
      }
      return true
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
  /* width: 146px;
  height: 146px;
  line-height: 146px; */
  text-align: center;
}
.image {
  /* width: 146px;
  height: 146px; */
  display: block;
}
</style>
