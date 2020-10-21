<template>
  <div class="app-container">
    <div class="design-title">宫格导航</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="120px">
      <el-form-item label="外边距" prop="margin">
        <el-slider
          v-model="form.margin"
          show-input
          :max="10"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="图片大小" prop="size">
        <el-slider
          v-model="form.size"
          show-input
          :min="30"
          :max="max"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="列数" prop="column">
        <el-radio-group v-model="form.column" size="mini" @change="changeColumn">
          <el-radio-button border :label="3">3列</el-radio-button>
          <el-radio-button border :label="4">4列</el-radio-button>
          <el-radio-button border :label="5">5列</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="风格" prop="style">
        <el-radio-group v-model="form.style" size="mini">
          <el-radio-button border label="square">平角</el-radio-button>
          <el-radio-button border label="round">圆角</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="文字颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
      <el-divider />
      <el-form-item prop="images" label-width="0px">
        <draggable
          v-model="form.images"
          :animation="500"
          :scroll="true"
          handle=".design-handle-move"
        >
          <div v-for="(item, index) in form.images" :key="index">
            <el-card style="margin-bottom: 5px;">
              <div slot="header" class="design-handle-move">
                <i class="el-icon-circle-close diy-card-close" :data-index="index" @click="removeImage" />
              </div>
              <el-form-item label="图片" label-width="80px">
                <upload-single
                  :action="action"
                  :url="item.image"
                  :width="80"
                  :height="80"
                  :index="index"
                  @onSuccess="onSuccess"
                />
              </el-form-item>
              <el-form-item label="名称" label-width="90px">
                <el-input v-model="item.text" size="mini" placeholder="名称" />
              </el-form-item>
              <el-form-item label="跳转地址" label-width="90px">
                <el-input v-model="item.link" size="mini" placeholder="跳转地址" />
              </el-form-item>
              <el-form-item label="登录状态" label-width="90px">
                <el-radio-group v-model="item.login" size="mini">
                  <el-radio-button border :label="false">不需要登录</el-radio-button>
                  <el-radio-button border :label="true">需要登录</el-radio-button>
                </el-radio-group>
              </el-form-item>
            </el-card>
          </div>
        </draggable>
      </el-form-item>
    </el-form>
    <el-button size="small" round plain style="width: 100%" @click="addImage">添加图片</el-button>
  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'
import draggable from 'vuedraggable'

export default {
  name: 'DesignGrid',
  components: {
    UploadSingle,
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.grid',
      form: {
        margin: 0,
        column: 3,
        style: 'square',
        background: '#fff',
        color: '#353535',
        size: 40,
        images: [
          {
            image: '',
            link: '',
            text: '名称',
            login: false
          }
        ]
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
    },
    max () {
      if (this.form.column === 3) {
        return 100
      } else if (this.form.column === 4) {
        return 60
      }
      return 50
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
    changeColumn (column) {
      if (column === 3) {
        this.form.size = 100
      } else if (column === 4) {
        this.form.size = 60
      } else {
        this.form.size = 50
      }
    },
    addImage () {
      this.form.images.push(
        {
          image: '',
          link: '',
          text: '名称',
          login: false
        }
      )
    },
    removeImage (event) {
      if (this.form.images.length > 1) {
        this.form.images.forEach((item, index) => {
          if (index === parseInt(event.currentTarget.dataset.index)) {
            this.form.images.splice(index, 1)
          }
        })
      } else {
        this.$message.error('至少添加一个')
      }
    },
    onSuccess (file) {
      this.form.images[file.index].image = file.response.data.url
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
.el-card__header {
  padding: 5px 20px;
  border-bottom: 0px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
.diy-card-close {
  font-size: 20px;
  color: #8c939d;
  position: absolute;
  top: 10px;
  right: 0px;
  cursor: pointer;
}
</style>
