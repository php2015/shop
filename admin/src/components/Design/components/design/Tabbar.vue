<template>
  <div class="app-container">
    <div class="design-title">底部导航栏</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="120px">
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="未选中文字颜色" prop="color">
        <el-color-picker v-model="form.color" />
      </el-form-item>
      <el-form-item label="选中文字颜色" prop="color_active">
        <el-color-picker v-model="form.color_active" />
      </el-form-item>
      <el-divider />
      <el-form-item prop="images" label-width="0px">
        <draggable
          v-model="form.item"
          :animation="500"
          handle=".design-handle-move"
        >
          <div v-for="(item, index) in form.item" :key="index">
            <el-card style="margin-bottom: 5px;">
              <div slot="header" class="design-handle-move">
                <i class="el-icon-circle-close diy-card-close" :data-index="index" @click="removeImage" />
              </div>
              <el-form-item label="选中的图标">
                <upload-single
                  :action="action"
                  :url="item.image_active"
                  :width="40"
                  :height="40"
                  :index="index"
                  @onSuccess="onActiveSuccess"
                />
              </el-form-item>
              <el-form-item label="未选中的图标">
                <upload-single
                  :action="action"
                  :url="item.image"
                  :width="40"
                  :height="40"
                  :index="index"
                  @onSuccess="onSuccess"
                />
              </el-form-item>
              <el-form-item label="名称">
                <el-input v-model="item.text" size="mini" placeholder="名称" />
              </el-form-item>
              <el-form-item label="跳转地址">
                <el-input v-model="item.link" size="mini" placeholder="跳转地址" />
              </el-form-item>
            </el-card>
          </div>
        </draggable>
      </el-form-item>
    </el-form>
    <el-button size="small" round plain style="width: 100%" @click="addImage">添加</el-button>
  </div>
</template>

<script>
import UploadSingle from '@/components/Upload/Single'
import draggable from 'vuedraggable'

export default {
  name: 'DesignTabbar',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.tabbar',
      form: {
        background: '#ffffff',
        color: '#646566',
        color_active: '#353535',
        item: [
          {
            text: '名称',
            link: '',
            image: '',
            image_active: ''
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
      this.form.item.push(
        {
          image: '',
          image_active: '',
          text: '名称',
          link: ''
        }
      )
    },
    removeImage (event) {
      if (this.form.item.length > 1) {
        this.form.item.forEach((item, index) => {
          if (index === parseInt(event.currentTarget.dataset.index)) {
            this.form.item.splice(index, 1)
          }
        })
      } else {
        this.$message.error('至少添加一个')
      }
    },
    onSuccess (file) {
      this.form.item[file.index].image = file.response.data.file
    },
    onActiveSuccess (file) {
      this.form.item[file.index].image_active = file.response.data.file
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
