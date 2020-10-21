<template>
  <div>
    <el-upload
      ref="upload"
      :multiple="true"
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
      <el-button v-loading="loading" type="primary">点击上传</el-button>
    </el-upload>
  </div>
</template>

<script>
import { getToken } from '@/utils/user'

export default {
  name: 'UploadButton',
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
      default: 'video/mp4'
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
    }
  },
  data () {
    return {
      loading: false
    }
  },
  computed: {},
  watch: {},
  created () {},
  methods: {
    onProgress (event, file) {
      this.loading = true
    },

    onSuccess (res, file) {
      this.loading = false
      if (res.code === 0) {
        this.$emit('onSuccess', file)
      } else {
        this.$message.error('上传出错了')
      }
    },

    onError (res) {
      console.log('Error:', res)
      this.loading = false
    },

    beforeUpload (file) {
      const size = file.size / 1024 / 1024 < this.size
      if (!size) {
        this.$message.error('文件大小不能超过 ' + this.size + 'MB!')
        return false
      }
      if (file.type !== 'video/mp4') {
        this.$message.error('文件格式错误!')
        return false
      }
      return true
    }
  }
}
</script>

<style>
/*  */
</style>
