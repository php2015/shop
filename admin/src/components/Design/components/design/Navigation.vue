<template>
  <div class="app-container">
    <div class="design-title">应用</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules">
      <el-form-item label="应用名称" prop="app_name">
        <el-input v-model="form.app_name" size="mini" />
      </el-form-item>
      <el-form-item label="应用皮肤" prop="app_skin">
        <div style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
          <div
            v-for="(item, index) in list"
            :key="index"
            class="skin-item"
            :style="'background:' + item.color"
            @click="selectSkin(item.value)"
          >
            <i v-if="item.checked" class="el-icon-success" style="font-size: 20px; color: #efefef;" />
          </div>
        </div>
      </el-form-item>
      <el-form-item label="自定义皮肤" prop="app_skin">
        <el-color-picker v-model="form.app_skin" @change="customChange" />
      </el-form-item>
      <el-form-item label="导航栏标题颜色" prop="navigation_bar_text_style">
        <el-radio-group v-model="form.navigation_bar_text_style" size="mini">
          <el-radio-button border label="#000000">黑色</el-radio-button>
          <el-radio-button border label="#ffffff">白色</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'DesignNavigation',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      list: [
        {
          color: '#ffffff',
          value: '#ffffff'
        }, {
          color: '#e41f19',
          value: '#e41f19'
        }, {
          color: '#ff9700',
          value: '#ff9700'
        }, {
          color: '#8dc63f',
          value: '#8dc63f'
        }, {
          color: '#9000ff',
          value: '#9000ff'
        }, {
          color: '#ec008c',
          value: '#ec008c'
        }, {
          color: '#0081ff',
          value: '#0081ff'
        }, {
          color: '#FF9999',
          value: '#FF9999'
        }
      ],
      form: {
        app_name: '',
        app_skin: '',
        navigation_bar_text_style: ''
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
          this.selectSkin(item.data.app_skin)
        }
      }
    })
  },
  methods: {
    selectSkin (skin) {
      const list = this.list
      list.forEach(item => {
        if (item.value === skin) {
          item.checked = true
        } else {
          item.checked = false
        }
      })
      this.list = JSON.parse(JSON.stringify(list))
      this.form.app_skin = skin
    },

    customChange (event) {
      const list = this.list
      list.forEach(item => {
        item.checked = false
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
.skin-item {
  width: 50px;
  height: 50px;
  line-height: 50px;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04);
  border-radius: 4px;
  margin-right: 20px;
  margin-bottom: 10px;
  text-align: center;
}

/*.active {
  border: 2px solid #ff3d00;
}*/
</style>
