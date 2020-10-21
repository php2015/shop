<template>
  <div class="app-container">
    <div class="design-title">商品</div>
    <el-divider />

    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="left" label-width="80px">
      <el-form-item label="商品数据" prop="data">
        <el-radio-group v-model="form.data" size="mini">
          <el-radio-button border :label="10">自动</el-radio-button>
          <el-radio-button border :label="20">选择</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-show="form.data == 20" label-width="0px">
        <placeholder-image :width="50" :height="50" :params.sync="form.goods" @click="visible = true" />
      </el-form-item>
      <el-form-item label="商品排序" prop="sort">
        <el-radio-group v-model="form.sort" size="mini">
          <el-radio-button border :label="10">综合</el-radio-button>
          <el-radio-button border :label="20">价格</el-radio-button>
          <el-radio-button border :label="30">销量</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <section v-if="form.data == 10">
        <el-form-item label="显示条数" prop="limit">
          <el-input-number v-model="form.limit" :min="6" :max="50" label="显示条数" />
        </el-form-item>
        <el-form-item label="商品分类" prop="category">
          <tree-select
            v-model="form.category"
            :options="category"
            :normalizer="normalizer"
            :default-expand-level="0"
            placeholder="商品分类，可不选默认全部"
            style="width:80%"
            size="mini"
            @input="categorySelected"
          />
        </el-form-item>
      </section>
      <el-divider />
      <el-form-item label="背景颜色" prop="background">
        <el-color-picker v-model="form.background" />
      </el-form-item>
      <el-form-item label="布局类型" prop="layout">
        <el-radio-group v-model="form.layout" size="mini">
          <el-radio-button border :label="1">详细列表</el-radio-button>
          <el-radio-button border :label="2">一行两个</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="显示字段" prop="field">
        <el-checkbox-group v-model="form.field" size="mini">
          <el-checkbox label="goods_name">商品名称</el-checkbox>
          <el-checkbox label="subtitle">副标题</el-checkbox>
          <el-checkbox label="sales_price">价格</el-checkbox>
          <el-checkbox label="line_price">划线价格</el-checkbox>
          <el-checkbox label="sales">销量</el-checkbox>
          <el-checkbox label="stock">库存</el-checkbox>
        </el-checkbox-group>
      </el-form-item>
    </el-form>
    <dialog-goods :visible.sync="visible" :params.sync="form.goods" @change="goodsSelected" />
  </div>
</template>

<script>
import PlaceholderImage from '@/components/Placeholder/Image'
import DialogGoods from '@/components/Dialog/Goods'
import { goodsCategory } from '@/api/shop/design'
import treeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  name: 'DesignGoods',
  components: {
    PlaceholderImage,
    DialogGoods,
    treeSelect
  },
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      loading: false,
      visible: false,
      category: [],
      form: {
        data: 10,
        goods: [],
        category: null,
        sort: 10,
        limit: 6,
        layout: 2,
        background: '#f6f6f6',
        field: [
          'goods_name',
          'subtitle',
          'sales_price',
          'line_price',
          'sales',
          'stock'
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
    this.getGoodsCategory()
  },
  methods: {
    getGoodsCategory () {
      this.loading = true
      goodsCategory().then(res => {
        this.category = res.data
      })
        .finally(() => {
          this.loading = false
        })
    },
    normalizer (node) {
      if (node.children && !node.children.length) {
        delete node.children
      }
      return {
        id: node.id,
        label: node.category_name,
        children: node.children
      }
    },

    categorySelected (id) {
      this.form.category_id = id
    },

    goodsSelected (data) {
      const goods = this.form.goods
      this.form.goods = goods.concat(data)
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
