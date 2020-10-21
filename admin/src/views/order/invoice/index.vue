<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.title"
        placeholder="发票抬头"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
    </div>
    <el-divider />

    <!-- 列表 -->
    <el-table
      ref="table"
      v-loading="loading"
      :data="list"
      stripe
      border
      highlight-current-row
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column prop="order.order_no" label="订单编号" align="center" />
      <el-table-column label="发票类型" align="center">
        <template slot-scope="scope">
          {{ scope.row.category == 10 ? '个人' : '单位' }}
        </template>
      </el-table-column>
      <el-table-column label="发票抬头" align="center">
        <template slot-scope="scope">
          {{ scope.row.title }}
        </template>
      </el-table-column>
      <el-table-column prop="tax_no" label="纳税人识别号" align="center" />
      <el-table-column prop="phone" label="手机号" align="center" />
      <el-table-column prop="code" label="发票代码" align="center" />
      <el-table-column prop="issue_time" label="开票时间" align="center" />
      <el-table-column label="状态" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.status == 10" type="info" effect="dark">未开票</el-tag>
          <el-tag v-if="scope.row.status == 20" type="success" effect="dark">已开票</el-tag>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/order/invoice/issue/' + scope.row.id)"
          >开票</el-link>
        </template>
      </el-table-column>
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
import { list } from '@/api/order/invoice'
import Pagination from '@/components/Pagination'

export default {
  name: 'OrderInvoice',
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

<style scoped>
/*  */
</style>
