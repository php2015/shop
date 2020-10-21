<template>
  <div>
    <el-dialog title="选择商品" :visible.sync="visible" :before-close="beforeClose" :destroy-on-close="true" width="80%">
      <!-- 查询 -->
      <div class="filter-container">
        <el-input
          v-model="query.goods_name"
          placeholder="商品名称"
          style="width: 200px;"
          class="filter-item"
          clearable
          @keyup.enter.native="handleSearch"
        />
        <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
        <el-button type="success" icon="el-icon-circle-check" @click="handleSubmit">确定</el-button>
      </div>
      <el-divider />

      <!-- 列表 -->
      <el-table
        ref="table"
        v-loading="loading"
        stripe
        border
        highlight-current-row
        :data="list"
        style="width: 100%"
        @sort-change="sortChange"
      >
        <el-table-column fixed type="selection" width="55" align="center" :selectable="handleDisable" />
        <el-table-column prop="id" label="ID" sortable="custom" />
        <el-table-column label="图片" align="center">
          <template slot-scope="scope">
            <el-image
              style="width: 60px; height: 60px"
              :src="scope.row.image_url"
              :preview-src-list="[scope.row.image_url]"
            />
          </template>
        </el-table-column>
        <el-table-column prop="category.category_name" label="商品分类" />
        <el-table-column prop="goods_name" label="商品名称" />
        <el-table-column prop="sales_price" label="价格" sortable="custom" />
        <el-table-column prop="stock" label="库存" sortable="custom" />
        <el-table-column prop="sales" label="销量" sortable="custom" />
        <el-table-column prop="status" label="状态" align="center">
          <template slot-scope="scope">
            <el-tag v-if="scope.row.status == 10" type="info" effect="dark">已下架</el-tag>
            <el-tag v-if="scope.row.status == 20" type="success" effect="dark">销售中</el-tag>
          </template>
        </el-table-column>
      </el-table>
      <!-- 分页 -->
      <pagination
        v-show="page_total > 1"
        :total="total"
        :page.sync="query.page"
        :limit.sync="query.limit"
        @pagination="getList"
      />
    </el-dialog>
  </div>
</template>

<script>
import { goods } from '@/api/dialog/index'
import Pagination from '@/components/Pagination'

export default {
  name: 'DialogGoods',
  components: {
    Pagination
  },
  mixins: [],
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    params: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      loading: false,
      list: null,
      total: 0,
      page_total: 0,
      query: {
        page: 1,
        limit: 10,
        sort: 'id:desc'
      }
    }
  },
  computed: {},
  watch: {
    property: {
      immediate: true,
      handler (value) {
        this.getList()
      }
    }
  },
  created () {},
  methods: {
    getList () {
      this.loading = true
      goods(this.query)
        .then(res => {
          this.list = res.data.data
          this.total = res.data.total
          this.page_total = res.data.last_page
        })
        .finally(() => {
          this.loading = false
        })
    },

    sortChange (data) {
      const { prop, order } = data
      if (order !== null) {
        if (order === 'ascending') {
          this.query.sort = prop + ':asc'
        } else {
          this.query.sort = prop + ':desc'
        }
        this.handleSearch()
      } else {
        this.query.sort = 'id:desc'
        this.handleSearch()
      }
    },

    handleSearch () {
      this.query.page = 1
      this.getList()
    },

    handleDisable (row, index) {
      const id = []
      this.params.forEach(item => {
        id.push(item.id)
      })
      if (id.indexOf(row.id) >= 0) {
        return false
      }
      return true
    },

    handleSubmit () {
      const data = this.$refs.table.selection
      const result = []

      if (data.length > 0) {
        data.forEach(item => {
          result.push(
            {
              id: item.id,
              image: item.image_url
            }
          )
        })
        this.$emit('change', result)
        this.beforeClose()
      } else {
        this.$message.warning('至少选择一条数据')
      }
    },

    beforeClose () {
      this.$emit('update:visible', false)
    }
  }
}
</script>

<style>
.el-button {
  z-index: 0;
}
</style>
