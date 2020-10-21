<template>
  <div class="app-container">
    <div class="design-title">文本块</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="高度" prop="height">
        <el-slider
          v-model="form.height"
          show-input
          :min="20"
          :max="200"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="文本内容" prop="content">
        <el-input v-model="form.content" size="mini" placeholder="文本内容" />
      </el-form-item>
      <el-form-item label="显示位置" prop="text_align" size="mini">
        <el-radio-group v-model="form.text_align">
          <el-radio-button border label="left">左</el-radio-button>
          <el-radio-button border label="center">中</el-radio-button>
          <el-radio-button border label="right">右</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="字体大小" prop="font_size" size="mini">
        <el-radio-group v-model="form.font_size">
          <el-radio-button border label="large">大</el-radio-button>
          <el-radio-button border label="medium">中</el-radio-button>
          <el-radio-button border label="small">小</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="是否加粗" prop="font_weight" size="mini">
        <el-radio-group v-model="form.font_weight">
          <el-radio-button border label="normal">否</el-radio-button>
          <el-radio-button border label="bold">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="字体颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="背景图片" prop="background_image">
        <upload-single
          :action="action"
          :url="form.background_image"
          :width="120"
          :height="60"
          @onSuccess="onSuccess"
        />
      </el-form-item>
      <el-form-item label="链接地址" prop="link">
        <el-input v-model="form.link" size="mini" placeholder="跳转地址" />
      </el-form-item>
      <el-form-item label="链接提示" prop="link_tips">
        <el-radio-group v-model="form.link_tips">
          <el-radio-button border label="none">无</el-radio-button>
          <el-radio-button border label="arrow">箭头</el-radio-button>
          <el-radio-button border label="more">更多</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>

  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'

export default {
  name: 'DesignText',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.text',
      form: {
        height: 50,
        content: '',
        color: '#353535',
        background: '#ffffff',
        background_image: '',
        font_size: 'medium',
        font_weight: 'normal',
        text_align: 'left',
        link: '',
        link_tips: 'none'
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
      this.form.background_image = file.response.data.url
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
