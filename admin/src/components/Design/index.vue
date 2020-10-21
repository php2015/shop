<template>
  <div style="padding: 10px;">
    <el-row :gutter="5">
      <!-- 功能区 -->
      <!-- 基础组件 -->
      <el-col style="min-width: 360px; width: 360px;" class="left">
        <section v-if="page != 'category'">
          <div style="font-size: 14px; padding: 10px; color: #909399;">基础组件</div>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="swiper"
                @click="itemClick"
              >
                <svg-icon icon-class="image" style="font-size: 20px;" />
                <div>图片轮播</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="image"
                @click="itemClick"
              >
                <svg-icon icon-class="image" style="font-size: 20px;" />
                <div>图片</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="cube"
                @click="itemClick"
              >
                <svg-icon icon-class="layout" style="font-size: 20px;" />
                <div>魔方</div>
              </div>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="video"
                @click="itemClick"
              >
                <svg-icon icon-class="video" style="font-size: 20px;" />
                <div>视频</div>
              </div>
            </el-col>
          </el-row>

          <!-- 商城组件 -->
          <div style="font-size: 14px; padding: 10px; color: #909399;">商城组件</div>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="search"
                @click="itemClick"
              >
                <svg-icon icon-class="search" style="font-size: 20px;" />
                <div>搜索框</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="notice"
                @click="itemClick"
              >
                <svg-icon icon-class="sound" style="font-size: 20px;" />
                <div>系统公告</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="grid"
                @click="itemClick"
              >
                <svg-icon icon-class="store" style="font-size: 20px;" />
                <div>宫格导航</div>
              </div>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="cell"
                @click="itemClick"
              >
                <svg-icon icon-class="database" style="font-size: 20px;" />
                <div>单元格导航</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="goods"
                @click="itemClick"
              >
                <svg-icon icon-class="goods" style="font-size: 20px;" />
                <div>商品</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="group"
                @click="itemClick"
              >
                <svg-icon icon-class="tags" style="font-size: 20px;" />
                <div>商品分组</div>
              </div>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="coupon"
                @click="itemClick"
              >
                <svg-icon icon-class="coupon" style="font-size: 20px;" />
                <div>优惠卷</div>
              </div>
            </el-col>
          </el-row>

          <!-- 工具组件 -->
          <div style="font-size: 14px; padding: 10px; color: #909399;">工具组件</div>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="text"
                @click="itemClick"
              >
                <i class="el-icon-document" style="font-size: 20px;" />
                <div>文本块</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="rich"
                @click="itemClick"
              >
                <i class="el-icon-edit-outline" style="font-size: 20px;" />
                <div>富文本</div>
              </div>
            </el-col>
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="blank"
                @click="itemClick"
              >
                <i class="el-icon-document-remove" style="font-size: 20px;" />
                <div>辅助空白</div>
              </div>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="8">
              <div
                class="grid-content bg-purple"
                data-type="line"
                @click="itemClick"
              >
                <i class="el-icon-minus" style="font-size: 20px;" />
                <div>分割线</div>
              </div>
            </el-col>
          </el-row>
        </section>
        <section v-else>
          <el-alert
            title="系统提示"
            type="info"
            description="该页面暂时不支持其他组件。"
            show-icon
            :closable="false"
          />
        </section>
        <div class="buttom-handle">
          <el-button type="success" size="medium" round @click="submit">保存发布</el-button>
        </div>
      </el-col>
      <!-- 功能区 -->

      <!-- 预览区 -->
      <el-col style="min-width: 420px; width: 420px;">
        <div class="main">
          <draggable
            v-model="params"
            :move="move"
            :animation="500"
            :scroll="true"
            draggable=".drag"
            style="height: 700px; overflow-y: auto; overflow-x:hidden; padding-bottom: 60px; color: #fff;"
          >
            <div
              v-for="(item, index) in params"
              :key="item.id"
              :class="[item.default !== true ? 'drag optional' : '', currentIndex==index && item.default !== true ? 'selected' : '']"
              :data-id="item.id"
              :data-index="index"
              :data-type="item.type"
              :data-disabled="item.disabled"
              @click="itemSelect"
            >
              <!-- 组件 -->
              <navigation-preview v-if="item.type == 'navigation'" :id="item.id" />
              <tabbar-preview v-if="item.type == 'tabbar'" :id="item.id" />
              <category-preview v-if="item.type == 'category'" :id="item.id" />
              <swiper-preview v-if="item.type == 'swiper'" :id="item.id" />
              <images-preview v-if="item.type == 'image'" :id="item.id" />
              <cube-preview v-if="item.type == 'cube'" :id="item.id" />
              <video-preview v-if="item.type == 'video'" :id="item.id" />
              <search-preview v-if="item.type == 'search'" :id="item.id" />
              <notice-preview v-if="item.type == 'notice'" :id="item.id" />
              <grid-preview v-if="item.type == 'grid'" :id="item.id" />
              <cell-preview v-if="item.type == 'cell'" :id="item.id" />
              <coupon-preview v-if="item.type == 'coupon'" :id="item.id" />
              <goods-preview v-if="item.type == 'goods'" :id="item.id" />
              <goods-group-preview v-if="item.type == 'group'" :id="item.id" />
              <text-preview v-if="item.type == 'text'" :id="item.id" />
              <rich-preview v-if="item.type == 'rich'" :id="item.id" />
              <blank-preview v-if="item.type == 'blank'" :id="item.id" />
              <line-preview v-if="item.type == 'line'" :id="item.id" />
              <mine-preview v-if="item.type == 'mine'" :id="item.id" />
              <fixd-preview v-if="item.type == 'fixd'" :id="item.id" />
              <!-- 组件 -->
              <div class="btn-edit-del" :data-id="item.id" @click.stop="itemRemove">
                <div class="btn-del">删除</div>
              </div>
            </div>
          </draggable>
        </div>
      </el-col>
      <!-- 预览区 -->

      <!-- 设计区 -->
      <el-col style="width: 100%">
        <div class="design">
          <el-scrollbar style="height: 100%;">
            <navigation-design v-if="currentType == 'navigation'" :id="currentId" :key="currentId" />
            <tabbar-design v-if="currentType == 'tabbar'" :id="currentId" :key="currentId" />
            <category-design v-if="currentType == 'category'" :id="currentId" :key="currentId" />
            <swiper-design v-if="currentType == 'swiper'" :id="currentId" :key="currentId" />
            <images-design v-if="currentType == 'image'" :id="currentId" :key="currentId" />
            <cube-design v-if="currentType == 'cube'" :id="currentId" :key="currentId" />
            <video-design v-if="currentType == 'video'" :id="currentId" :key="currentId" />
            <search-design v-if="currentType == 'search'" :id="currentId" :key="currentId" />
            <notice-design v-if="currentType == 'notice'" :id="currentId" :key="currentId" />
            <grid-design v-if="currentType == 'grid'" :id="currentId" :key="currentId" />
            <cell-design v-if="currentType == 'cell'" :id="currentId" :key="currentId" />
            <coupon-design v-if="currentType == 'coupon'" :id="currentId" :key="currentId" />
            <goods-design v-if="currentType == 'goods'" :id="currentId" :key="currentId" />
            <goods-group-design v-if="currentType == 'group'" :id="currentId" :key="currentId" />
            <text-design v-if="currentType == 'text'" :id="currentId" :key="currentId" />
            <rich-design v-if="currentType == 'rich'" :id="currentId" :key="currentId" />
            <blank-design v-if="currentType == 'blank'" :id="currentId" :key="currentId" />
            <line-design v-if="currentType == 'line'" :id="currentId" :key="currentId" />
            <mine-design v-if="currentType == 'mine'" :id="currentId" :key="currentId" />
          </el-scrollbar>
        </div>
      </el-col>
      <!-- 设计区 -->
    </el-row>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
// 设计组件
import NavigationDesign from './components/design/Navigation'
import TabbarDesign from './components/design/Tabbar'
import CategoryDesign from './components/design/Category'
import SwiperDesign from './components/design/Swiper'
import ImagesDesign from './components/design/Image'
import CubeDesign from './components/design/Cube'
import VideoDesign from './components/design/Video'
import SearchDesign from './components/design/Search'
import NoticeDesign from './components/design/Notice'
import GridDesign from './components/design/Grid'
import CellDesign from './components/design/Cell'
import CouponDesign from './components/design/Coupon'
import GoodsDesign from './components/design/Goods'
import GoodsGroupDesign from './components/design/GoodsGroup'
import TextDesign from './components/design/Text'
import RichDesign from './components/design/Rich'
import BlankDesign from './components/design/Blank'
import LineDesign from './components/design/Line'
import MineDesign from './components/design/Mine'
// 预览组件
import NavigationPreview from './components/preview/Navigation'
import TabbarPreview from './components/preview/Tabbar'
import CategoryPreview from './components/preview/Category'
import SwiperPreview from './components/preview/Swiper'
import ImagesPreview from './components/preview/Image'
import CubePreview from './components/preview/Cube'
import VideoPreview from './components/preview/Video'
import SearchPreview from './components/preview/Search'
import NoticePreview from './components/preview/Notice'
import GridPreview from './components/preview/Grid'
import CellPreview from './components/preview/Cell'
import CouponPreview from './components/preview/Coupon'
import GoodsPreview from './components/preview/Goods'
import GoodsGroupPreview from './components/preview/GoodsGroup'
import TextPreview from './components/preview/Text'
import RichPreview from './components/preview/Rich'
import BlankPreview from './components/preview/Blank'
import LinePreview from './components/preview/Line'
import MinePreview from './components/preview/Mine'
import FixdPreview from './components/preview/Fixd'

export default {
  name: 'Design',
  components: {
    draggable,
    // 设计组件
    NavigationDesign,
    TabbarDesign,
    CategoryDesign,
    SwiperDesign,
    ImagesDesign,
    CubeDesign,
    VideoDesign,
    SearchDesign,
    NoticeDesign,
    GridDesign,
    CellDesign,
    CouponDesign,
    GoodsDesign,
    GoodsGroupDesign,
    TextDesign,
    RichDesign,
    BlankDesign,
    LineDesign,
    MineDesign,
    // 预览组件
    NavigationPreview,
    TabbarPreview,
    CategoryPreview,
    SwiperPreview,
    ImagesPreview,
    CubePreview,
    VideoPreview,
    SearchPreview,
    NoticePreview,
    GridPreview,
    CellPreview,
    CouponPreview,
    GoodsPreview,
    GoodsGroupPreview,
    TextPreview,
    RichPreview,
    BlankPreview,
    LinePreview,
    MinePreview,
    FixdPreview
  },
  mixins: [],
  props: {},
  data () {
    return {
      submitLoading: false,
      currentIndex: null,
      currentType: null,
      currentId: null
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
    page () {
      return this.$store.state.design.page
    },
    id () {
      let id = 0
      this.params.forEach(item => {
        if (item.id > id) id = item.id
      })
      return id + 1
    }
  },
  watch: {
    property: {
      immediate: true,
      handler () {
        this.$store.commit('design/SET_PARAMS', [])
      }
    }
  },
  created () {},
  methods: {
    // 添加组件到预览区
    itemClick (event) {
      this.currentId = this.id
      this.currentIndex = this.params.length
      this.currentType = event.currentTarget.dataset.type
      this.params.push(
        {
          id: this.currentId,
          type: this.currentType,
          data: {}
        }
      )
    },
    // 选择组件到设计区
    itemSelect (event) {
      if (event.currentTarget.dataset.disabled) return false
      this.currentId = parseInt(event.currentTarget.dataset.id)
      this.currentIndex = parseInt(event.currentTarget.dataset.index)
      this.currentType = event.currentTarget.dataset.type
    },
    // 从预览区中删除组件
    itemRemove (event) {
      this.params.forEach((item, index) => {
        if (item.id === parseInt(event.currentTarget.dataset.id)) {
          this.params.splice(index, 1)
          this.currentIndex = null
          this.currentType = null
          this.currentId = null
        }
      })
    },
    move (event) {
      this.currentId = event.draggedContext.element.id
      this.currentType = event.draggedContext.element.type
      this.currentIndex = event.draggedContext.futureIndex
      // console.log(event.draggedContext.index)
      // console.log(event.draggedContext.element)
      // console.log(event.draggedContext.futureIndex)
      // console.log(event.relatedContext.index)
      // console.log(event.relatedContext.element)
      // console.log(event.relatedContext.list)
      // console.log(event.relatedContext.component)
    },
    submit () {
      this.$emit('submit', this.params)
    }
  }
}
</script>

<style>
.el-row {
  margin-bottom: 10px;
  display: flex;
}
.bg-purple {
  cursor: pointer;
  /* color: #F56C6C; */
}
.left .disabled {
  color: #999;
  cursor: auto;
}
.grid-content {
  border-radius: 4px;
  min-height: 66px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 12px;
  line-height: 20px;
  border: 1px solid #efefef;
  color: #606266;
  box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
}
.left {
  background: #fff;
  padding: 10px;
  min-height: 700px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04);
}
.main {
  position: relative;
  min-height: 700px;
  max-height: 700px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04);
  background: #f6f6f6;
  border-top: 0;
  user-select: none;
  line-height: normal;
}
.drag {
  display: block;
  overflow: hidden;
  font-size: 12px;
}
.optional {
  position: relative;
}
.optional:before {
  content: "";
}
.optional.selected:before, .optional:hover:before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border: 2px dashed #409EFF;
  cursor: move;
  z-index: 99;
}
.drag.selected .btn-edit-del, .drag:hover .btn-edit-del {
  display: block;
}
.btn-edit-del {
  height: 16px;
  position: absolute;
  right: 2px;
  top: 2px;
  display: none;
  z-index: 999;
}
.btn-edit-del > div {
  width: 32px;
  height: 16px;
  line-height: 16px;
  display: inline-block;
  text-align: center;
  font-size: 10px;
  color: #fff;
  background: #F56C6C;
  margin-left: 2px;
  cursor: pointer;
  position: relative;
  z-index: 999;
}
.design {
  min-height: 700px;
  height: 700px;
  box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
  font-size: 14px;
}
.buttom-handle {
  position: relative;
  bottom: 0;
  left: 0;
  right: 0;
  min-height: 50px;
  height: 50px;
  line-height: 50px;
  width: 100%;
  text-align: center;
  /* z-index: 9999; */
}
/* 设计元素 */
.design-title {
  font-weight: bold;
}
.design-handle-move {
  position: relative;
  min-height: 10px;
}
.design-handle-move:hover {
  cursor: move;
}
</style>
