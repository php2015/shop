<template>
  <div class="app-container">
    <div class="design-title">图片轮播</div>
    <el-divider />

    <el-form ref="form" :model="form" :rules="rules" label-position="left" label-width="110px">
      <el-form-item label="样式" prop="style">
        <el-radio-group v-model="form.style" size="mini">
          <el-radio-button border label="card">卡片式</el-radio-button>
          <el-radio-button border label="plane">平面式</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.style == 'plane'" label="页面边距" prop="padding">
        <el-slider
          v-model="form.padding"
          show-input
          :max="50"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="图片高度" prop="height">
        <el-slider
          v-model="form.height"
          show-input
          :min="50"
          :max="500"
          :step="10"
          input-size="mini"
          :show-tooltip="false"
        />
      </el-form-item>
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="显示指示点" prop="indicatorDots">
        <el-radio-group v-model="form.indicatorDots" size="mini">
          <el-radio-button border :label="false">否</el-radio-button>
          <el-radio-button border :label="true">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="指示点颜色" prop="indicatorColor">
        <el-color-picker v-model="form.indicatorColor" />
      </el-form-item>
      <el-form-item label="选中指示点颜色" prop="indicatorActiveColor">
        <el-color-picker v-model="form.indicatorActiveColor" />
      </el-form-item>
      <el-form-item label="是否自动切换" prop="autoplay" size="mini">
        <el-radio-group v-model="form.autoplay">
          <el-radio-button border :label="false">否</el-radio-button>
          <el-radio-button border :label="true">是</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="切换时间间隔" prop="interval">
        <el-input-number v-model.number="form.interval" size="mini" :min="0" />
      </el-form-item>
      <el-divider />
      <el-form-item prop="images" label-width="0px">
        <draggable
          v-model="form.images"
          :animation="500"
          handle=".design-handle-move"
        >
          <div v-for="(item, index) in form.images" :key="index">
            <div>
              <el-card style="margin-bottom: 5px;">
                <div slot="header" class="design-handle-move">
                  <i class="el-icon-circle-close diy-card-close" :data-index="index" @click="removeImage" />
                </div>
                <el-form-item label="图片" label-width="80px">
                  <upload-single
                    :action="action"
                    :url="item.image"
                    :width="120"
                    :height="60"
                    :index="index"
                    @onSuccess="onSuccess"
                  />
                </el-form-item>
                <el-form-item label="跳转地址" label-width="80px">
                  <el-input v-model="item.link" size="mini" placeholder="跳转地址" />
                </el-form-item>
              </el-card>
            </div>
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
  name: 'DesignSwiper',
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
      action: process.env.VUE_APP_BASE_API + '/upload/design.swiper',
      form: {
        padding: 0,
        height: 260,
        style: 'card',
        background: '#ffffff',
        indicatorDots: true,
        indicatorColor: '#ffffff',
        indicatorActiveColor: '#FF9700',
        autoplay: true,
        interval: 5000,
        images: [
          {
            image: '',
            link: ''
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
          link: ''
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
        this.$message.error('至少上传一张图片')
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
/*  */
</style>
