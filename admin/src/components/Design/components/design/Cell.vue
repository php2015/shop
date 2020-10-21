<template>
  <div class="app-container">
    <div class="design-title">单元格导航</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="120px">
      <el-form-item label="外边距" prop="margin">
        <el-slider
          v-model="form.margin"
          show-input
          :max="20"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="风格" prop="style">
        <el-radio-group v-model="form.style" size="mini">
          <el-radio-button border label="square">平角</el-radio-button>
          <el-radio-button border label="round">圆角</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="文字颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
      <el-divider />
      <el-form-item prop="images" label-width="0px">
        <draggable
          v-model="form.images"
          :animation="500"
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
              <el-form-item label="登录状态" label-width="90px">
                <el-radio-group v-model="item.login" size="mini">
                  <el-radio-button border :label="false">不需要登录</el-radio-button>
                  <el-radio-button border :label="true">需要登录</el-radio-button>
                </el-radio-group>
              </el-form-item>
              <el-form-item label="名称" label-width="90px">
                <el-input v-model="item.text" size="mini" placeholder="名称" />
              </el-form-item>
              <el-form-item label="跳转地址" label-width="90px">
                <el-input v-model="item.link" size="mini" placeholder="跳转地址" />
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
  name: 'DesignCell',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.cell',
      form: {
        margin: 0,
        style: 'square',
        color: '#353535',
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
    addImage () {
      this.form.images.push(
        {
          image: '',
          link: '',
          text: '名称',
          label: '',
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
