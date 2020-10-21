<template>
  <div class="app-container">
    <div class="design-title">富文本</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="上下边距" prop="padding_top_bottom">
        <el-slider
          v-model="form.padding_top_bottom"
          show-input
          :max="50"
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
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item prop="text" label-width="0px">
        <tinymce v-model="content" :height="300" />
      </el-form-item>
    </el-form>

  </div>
</template>

<script>
import Tinymce from '@/components/Tinymce'

export default {
  name: 'DesignRich',
  components: {
    Tinymce
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      content: '',
      form: {
        padding_top_bottom: 0,
        padding_left_right: 0,
        background: '#fff',
        content: '请输入富文本内容...'
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
    },
    content () {
      this.form.content = encodeURIComponent(this.content)
    }
  },
  created () {
    this.params.forEach(item => {
      if (item.id === this.id) {
        if (JSON.stringify(item.data) === '{}') {
          this.handleSubmit(this.form)
        } else {
          this.form = item.data
          this.content = decodeURIComponent(item.data.content)
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
