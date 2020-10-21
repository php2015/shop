<template>
  <div class="app-container">
    <div class="design-title">个人信息</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="背景图片" prop="background_image">
        <upload-single
          :action="action"
          :url="form.background_image"
          :width="120"
          :height="60"
          @onSuccess="onSuccess"
        />
      </el-form-item>
      <el-form-item label="字体颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
    </el-form>

  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'

export default {
  name: 'DesignMine',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.mine',
      form: {
        background_image: '',
        color: '#353535'
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
