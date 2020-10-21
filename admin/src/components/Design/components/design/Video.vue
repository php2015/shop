<template>
  <div class="app-container">
    <div class="design-title">视频</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="上下边距" prop="padding_top_bottom">
        <el-slider
          v-model="form.padding_top_bottom"
          show-input
          :max="100"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="左右边距" prop="padding_left_right">
        <el-slider
          v-model="form.padding_left_right"
          show-input
          :max="50"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="视频高度" prop="height">
        <el-slider
          v-model="form.height"
          show-input
          :min="100"
          :max="800"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="背景色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="自动播放" prop="autoplay">
        <el-radio-group v-model="form.autoplay" size="mini">
          <el-radio-button border :label="false">否</el-radio-button>
          <el-radio-button border :label="true">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-divider />
      <el-form-item prop="video" label-width="0px">
        <el-card style="margin-bottom: 10px;">
          <el-form-item label="封面" label-width="80px">
            <upload-single
              :action="posterAction"
              :url="form.video.poster"
              :width="120"
              :height="80"
              @onSuccess="onPosterSuccess"
            />
          </el-form-item>
          <el-form-item label="视频" label-width="80px">
            <upload-single
              :action="action"
              :url="form.video.link"
              :width="120"
              :height="80"
              :size="50"
              accept="video/mp4"
              @onSuccess="onSuccess"
            />
          </el-form-item>
        </el-card>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'

export default {
  name: 'DesignVideo',
  components: {
    UploadSingle
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      action: process.env.VUE_APP_BASE_API + '/upload/design.video.video',
      posterAction: process.env.VUE_APP_BASE_API + '/upload/design.video.poster',
      form: {
        padding_top_bottom: 0,
        padding_left_right: 0,
        height: 200,
        autoplay: false,
        background: '#fff',
        video: {
          link: '',
          poster: ''
        }
      },
      rules: {}
    }
  },
  computed: {
    params: {
      get () {
        return this.$store.state.design.params
      },
      set (value) {
        this.$store.commit('design/SET_PARAMS', value)
      }
    }
  },
  watch: {
    form: {
      handler (value) {
        this.handleSubmit(value)
      },
      deep: true
    }
  },
  created () {
    this.params.forEach(item => {
      if (item.id === this.id) {
        if (JSON.stringify(item.data) === '{}') {
          this.handleSubmit(this.form)
        } else {
          this.form = item.data
        }
      }
    })
  },
  methods: {
    onSuccess (file) {
      this.form.video.link = file.response.data.url
    },
    onPosterSuccess (file) {
      this.form.video.poster = file.response.data.url
    },
    handleSubmit (value) {
      this.params.forEach((item, index) => {
        if (item.id === this.id) {
          this.params[index].data = value
        }
      })
    }
  }
}
</script>

<style>
.title {
  font-weight: bold;
  padding: 10px;
}
</style>
