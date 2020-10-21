<template>
  <div>
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
      <el-button
        style="margin-left: 10px;"
        type="success"
        icon="el-icon-edit-outline"
        @click="$router.push('/goods/add')"
      >添加</el-button>
      <el-button
        style="margin-left: 10px;"
        icon="el-icon-sold-out"
        @click="handleStatus"
      >批量下架</el-button>
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
      <el-table-column fixed type="selection" width="55" align="center" />
      <el-table-column prop="id" label="ID" width="100" align="center" sortable="custom" />
      <el-table-column label="图片" width="80" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 60px; height: 60px"
            :src="scope.row.image_url"
            :preview-src-list="[scope.row.image_url]"
          />
        </template>
      </el-table-column>
      <el-table-column prop="category.category_name" label="商品分类" width="100" align="center" />
      <el-table-column prop="status" label="商品分组" width="100" align="center">
        <template slot-scope="scope">
          <div style="line-height: 30px;">
            <el-tag v-for="item in scope.row.group" :key="item.id" type="info">{{ item.group_name }}</el-tag>
          </div>
        </template>
      </el-table-column>
      <el-table-column prop="goods_name" label="商品名称" width="200" align="center" />
      <el-table-column prop="sales_price" label="价格" width="100" align="center" sortable="custom" />
      <el-table-column prop="stock" label="库存" width="100" align="center" sortable="custom" />
      <el-table-column prop="sales" label="销量" width="100" align="center" sortable="custom" />
      <el-table-column prop="sort" label="排序" width="100" align="center" sortable="custom" />
      <el-table-column label="物流支持" width="100" align="center">
        <template slot-scope="scope">
          <!-- 推荐 -->
          <div style="line-height: 30px;">
            <el-tag v-if="scope.row.is_express == 20" type="info">快递配送</el-tag>
            <el-tag v-if="scope.row.is_local == 20" type="info">同城配送</el-tag>
            <el-tag v-if="scope.row.is_fetch == 20" type="info">上门自提</el-tag>
          </div>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/goods/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link
            type="primary"
            icon="el-icon-sold-out"
            @click="handleStatus(scope.row.id)"
          >下架</el-link>
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
    <!-- 分页 -->
    <pagination
      :total="total"
      :page-total="page_total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import { list, doStatus, doRemove } from '@/api/goods'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'GoodsSales',
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
        sort: 'sort:asc',
        type: 1
      },
      inputValue: ''
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      this.loading = true
      list(this.query)
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
        this.query.sort = 'sort:asc'
        this.handleSearch()
      }
    },

    handleSearch () {
      this.query.page = 1
      this.getList()
    },

    handleRemove (data) {
      const params = typeof data === 'object' ? this.$refs.table.selection : data
      batchHandle(params, '确定删除吗？').then(id => {
        this.loading = true
        doRemove(id).then(res => {
          this.$message({
            message: res.msg,
            type: 'success'
          })
          this.getList()
        })
          .finally(() => {
            this.loading = false
          })
      })
    },

    handleStatus (data) {
      const params = typeof data === 'object' ? this.$refs.table.selection : data
      batchHandle(params, '确定下架商品吗？').then(id => {
        this.loading = true
        doStatus(id, 10).then(res => {
          this.$message({
            message: res.msg,
            type: 'success'
          })
          this.$router.go(0)
        })
          .finally(() => {
            this.loading = false
          })
      })
    }
  }
}
</script>

<style scoped>
/*  */
</style>
