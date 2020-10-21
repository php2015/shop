<template>
  <div class="app-container">
    <el-page-header content="购物车信息" @back="$router.push('/user')" />
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
      <el-table-column label="商品名称">
        <template slot-scope="scope">
          {{ scope.row.goods_name }}{{ scope.row.sku_name }}
        </template>
      </el-table-column>
      <el-table-column prop="quantity" label="数量" sortable="custom" align="center" />
      <el-table-column prop="sales_price" label="收藏价格" sortable="custom" align="center" />
      <el-table-column prop="sku.sales_price" label="当前价格" align="center" />
    </el-table>
    <!-- 分页 -->
    <pagination
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import { cart } from '@/api/user/detail'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserDetailCart',
  components: { Pagination },
  data () {
    return {
      loading: false,
      list: null,
      total: 0,
      page_total: 0,
      query: {
        page: 1,
        limit: 10,
        id: this.$route.params.id,
        sort: 'id:desc'
      }
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      this.loading = true
      cart(this.query)
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
    }
  }
}
</script>

<style>
/*  */
</style>
