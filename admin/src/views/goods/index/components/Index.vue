<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item label="商品分类" prop="category_id">
        <tree-select
          v-model="form.category_id"
          :options="category"
          :normalizer="normalizer"
          :default-expand-level="0"
          placeholder="商品分类"
          style="width:80%"
        />
      </el-form-item>
      <el-form-item label="商品名称" prop="goods_name">
        <el-input v-model.trim="form.goods_name" placeholder="商品名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="单位" prop="unit">
        <el-select v-model="form.unit" placeholder="单位" style="width:80%">
          <el-option
            v-for="item in unit"
            :key="item.id"
            :label="item.unit"
            :value="item.unit"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="商品卖点" prop="subtitle">
        <el-input v-model.trim="form.subtitle" placeholder="商品卖点" style="width:80%" />
        <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
          在商品详情页标题下面展示卖点信息，建议60字以内
        </el-alert>
      </el-form-item>
      <el-form-item label="商品分组" prop="group">
        <el-select v-model="form.group" multiple placeholder="请选择" style="width:80%">
          <el-option
            v-for="item in group"
            :key="item.id"
            :label="item.group_name"
            :value="item.id"
            :disabled="item.status == 10"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="商品支持" prop="support">
        <el-select v-model="form.support" multiple clearable placeholder="商品支持" style="width:80%">
          <el-option
            v-for="item in support"
            :key="item.id"
            :label="item.support_name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { edit, doEdit } from '@/api/goods'
import treeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  name: 'GoodsEditIndex',
  components: {
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
      submitLoading: false,
      category: [],
      group: [],
      support: [],
      unit: [],
      content: '',
      form: {
        id: null,
        goods_name: '',
        unit: '',
        category_id: null,
        group: null,
        support: null,
        subtitle: ''
      },
      rules: {
        category_id: [{ required: true, message: '请选择商品分类', trigger: 'change' }],
        goods_name: [{ required: true, message: '请输入商品名称', trigger: 'blur' }],
        unit: [{ required: true, message: '请输入单位名称', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    edit(this.id)
      .then(res => {
        const detail = res.data.detail
        this.category = res.data.category
        this.group = res.data.group
        this.support = res.data.support
        this.unit = res.data.unit
        this.content = detail.content
        this.form.id = detail.id
        this.form.goods_name = detail.goods_name
        this.form.unit = detail.unit
        this.form.category_id = detail.category_id
        this.form.group = this.getGroup(detail.group)
        this.form.support = this.getSupport(detail.support)
        this.form.subtitle = detail.subtitle
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    normalizer (node) {
      if (node.children && !node.children.length) {
        delete node.children
      }
      return {
        id: node.id,
        label: node.category_name,
        children: node.children,
        isDisabled: node.status === 10
      }
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          console.log(this.form)
          this.submitLoading = true
          doEdit(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    getGroup (data) {
      const result = []
      data.forEach(item => {
        result.push(item.id)
      })
      return result
    },

    getSupport (data) {
      const result = []
      data.forEach(item => {
        result.push(item.id)
      })
      return result
    }
  }
}
</script>

<style scoped>
/*  */
</style>

