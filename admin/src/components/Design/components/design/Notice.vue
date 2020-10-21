<template>
  <div class="app-container">
    <div class="design-title">系统公告</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="上下边距" prop="padding_top_bottom">
        <el-slider
          v-model="form.padding_top_bottom"
          show-input
          :max="20"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="文字颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
      <el-form-item label="公告内容" prop="content">
        <el-input v-model="form.content" size="mini" placeholder="公告内容" />
      </el-form-item>
      <el-form-item label="公告图标" prop="content">
        <upload-single
          :action="action"
          :url="form.icon"
          :width="40"
          :height="40"
          @onSuccess="onSuccess"
        />
      </el-form-item>
    </el-form>

  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'

export default {
  name: 'DesignNotice',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.notice',
      form: {
        padding_top_bottom: 0,
        background: '#fff',
        color: '#353535',
        content: '',
        icon: ''
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
    handleSubmit (value) {
      this.params.forEach((item, index) => {
        if (item.id === this.id) {
          this.params[index].data = value
        }
      })
    },

    onSuccess (file) {
      this.form.icon = file.response.data.url
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
