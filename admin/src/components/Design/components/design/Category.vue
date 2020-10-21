<template>
  <div class="app-container">
    <div class="design-title">分类</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules">
      <el-form-item label="布局类型" prop="layout">
        <el-radio-group v-model="form.layout">
          <div style="line-height: 60px">
            <el-radio border :label="10">一级分类(大图)</el-radio>
          </div>
          <div style="line-height: 60px">
            <el-radio border :label="20">一级分类(小图)</el-radio>
          </div>
          <div style="line-height: 60px">
            <el-radio border :label="30">一级分类(商品列表)</el-radio>
          </div>
          <div style="line-height: 60px">
            <el-radio border :label="40">二级分类</el-radio>
          </div>
        </el-radio-group>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'DesignCategory',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      form: {
        layout: 10
      },
      rules: {
        layout: [{ required: true, message: '布局类型', trigger: 'change' }]
      }
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
