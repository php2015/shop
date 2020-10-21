<template>
  <div class="app-container">
    <div class="design-title">搜索框</div>
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
      <el-form-item label="左右边距" prop="padding_left_right">
        <el-slider
          v-model="form.padding_left_right"
          show-input
          :max="20"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="样式" prop="style">
        <el-radio-group v-model="form.style" size="mini">
          <el-radio-button border label="square">方形</el-radio-button>
          <el-radio-button border label="round">圆角</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="是否吸顶" prop="sticky">
        <el-radio-group v-model="form.sticky" size="mini">
          <el-radio-button border :label="false">否</el-radio-button>
          <el-radio-button border :label="true">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="提示文字" prop="text">
        <el-input v-model="form.text" size="mini" placeholder="提示文字" />
      </el-form-item>
      <el-divider content-position="left">热词</el-divider>
      <el-form-item prop="keyword" label-width="0px">
        <draggable
          v-model="form.item"
          :animation="500"
        >
          <div v-for="(item, index) in form.keyword" :key="index">
            <el-card :key="index" style="margin-bottom: 10px; cursor: move;">
              <div slot="header" style="position: relative;">
                <i class="el-icon-circle-close diy-card-close" :data-index="index" @click="removeItem" />
              </div>
              <el-form-item label="热词" label-width="90px" style="padding-top: 5px;">
                <el-input v-model="item.text" size="mini" placeholder="热词" />
              </el-form-item>
            </el-card>
          </div>
        </draggable>
      </el-form-item>
    </el-form>
    <el-button size="small" round plain style="width: 100%" @click="addItem">添加一个</el-button>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
  name: 'DesignSearch',
  components: {
    draggable
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      form: {
        padding_top_bottom: 0,
        padding_left_right: 0,
        background: '#efefef',
        style: 'square',
        sticky: false,
        text: '搜索',
        keyword: []
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
    addItem () {
      console.log(this.form)
      this.form.keyword.push(
        {
          text: ''
        }
      )
    },
    removeItem (event) {
      this.form.keyword.forEach((item, index) => {
        if (index === parseInt(event.currentTarget.dataset.index)) {
          this.form.keyword.splice(index, 1)
        }
      })
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
