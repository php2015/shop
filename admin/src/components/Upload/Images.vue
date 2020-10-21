<template>
  <div>
    <el-upload
      ref="upload"
      list-type="picture-card"
      :multiple="true"
      :auto-upload="true"
      :accept="accept"
      :headers="headers"
      :action="action"
      :on-success="onSuccess"
      :on-error="onError"
      :on-progress="onProgress"
      :before-upload="beforeUpload"
      :on-preview="onPreview"
      :on-remove="onRemove"
      :file-list="fileList"
    >
      <i class="el-icon-plus" />
    </el-upload>
    <el-dialog :visible.sync="PreviewVisible">
      <img width="100%" :src="PreviewUrl">
    </el-dialog>
  </div>
</template>

<script>
import { getToken } from '@/utils/user'

export default {
  name: 'UploadImages',
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
    size: {
      type: Number,
      default: 5
    },
    fileList: {
      type: Array,
      default: () => ([])
    },
    width: {
      type: Number,
      default: 80
    }
  },
  data () {
    return {
      loading: false,
      PreviewVisible: false,
      PreviewUrl: ''
    }
  },
  computed: {},
  watch: {},
  created () {},
  methods: {
    onProgress (event, file) { },

    onSuccess (res, file, fileList) {
      // console.log('res:', res)
      // console.log('file:', file)
      // console.log('fileList:', fileList)
      if (res.code === 0) {
        const list = []
        fileList.forEach(item => {
          if (item.response) {
            list.push({
              name: item.response.data.file
            })
          } else {
            list.push({
              name: item.name
            })
          }
        })
        this.$emit('onSuccess', list)
      } else {
        this.$message.error('上传出错了')
      }
    },

    onRemove (file, fileList) {
      // console.log('file:', file)
      // console.log('fileList:', fileList)
      const list = []
      fileList.forEach(item => {
        list.push({
          name: item.name
        })
      })
      this.$emit('onRemove', list)
    },

    onPreview (file) {
      this.PreviewUrl = file.url
      this.PreviewVisible = true
    },

    onError (res) {
      console.log('Error:', res)
    },

    beforeUpload (file) {
      const size = file.size / 1024 / 1024 < this.size
      if (!size) {
        this.$message.error('图片大小不能超过 ' + this.size + 'MB!')
        return false
      }
      // if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/gif') {
      //   this.$message.error('图片格式错误!')
      //   return false
      // }
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
.el-upload--picture-card {
  background-color: #fbfdff;
  border: 1px dashed #c0ccda;
  border-radius: 6px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  width: 100px;
  height: 100px;
  line-height: 100px;
  vertical-align: top;
}
.el-upload-list--picture-card .el-upload-list__item {
  overflow: hidden;
  background-color: #fff;
  border: 1px solid #c0ccda;
  border-radius: 6px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  width: 100px;
  height: 100px;
  margin: 0 8px 8px 0;
  display: inline-block;
}
</style>
