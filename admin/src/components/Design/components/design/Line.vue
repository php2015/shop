<template>
  <div class="app-container">
    <div class="design-title">分割线</div>
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
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="样式" prop="style">
        <el-radio-group v-model="form.style" size="mini">
          <el-radio-button border label="solid">实线</el-radio-button>
          <el-radio-button border label="dashed">虚线</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="线条颜色" prop="border_color">
        <el-color-picker v-model="form.border_color" />
      </el-form-item>
      <el-form-item label="文字位置" prop="position">
        <el-radio-group v-model="form.position" size="mini">
          <el-radio-button border label="left">左</el-radio-button>
          <el-radio-button border label="center">中</el-radio-button>
          <el-radio-button border label="right">右</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="文字" prop="text">
        <el-input v-model="form.text" size="mini" placeholder="不填写将不显示文字" />
      </el-form-item>
      <el-form-item label="文字颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'DesignLine',
  components: {},
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
        padding_top_bottom: 1,
        background: '#fff',
        style: 'solid',
        border_color: '#ebedf0',
        position: 'left',
        color: '#969799',
        text: ''
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
