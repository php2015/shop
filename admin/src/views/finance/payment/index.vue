<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.payment_no"
        placeholder="支付编号"
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
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left" class="table-expand">
            <el-form-item label="用户">
              <span>{{ props.row.user.nickname }}</span>
            </el-form-item>
            <el-form-item label="支付编号">
              <span>{{ props.row.payment_no }}</span>
            </el-form-item>
            <el-form-item label="微信支付ID">
              <span>{{ props.row.transaction_id }}</span>
            </el-form-item>
            <el-form-item label="支付金额">
              <span>{{ props.row.payment_price }}</span>
            </el-form-item>
            <el-form-item label="支付时间">
              <span>{{ props.row.payment_time }}</span>
            </el-form-item>
            <el-form-item label="客户端IP">
              <span>{{ props.row.client_ip }}</span>
            </el-form-item>
            <el-form-item label="支付状态">
              <span v-if="props.row.status == 10" style="color:#909399">未支付</span>
              <span v-else style="color:#67C23A">已支付</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column prop="payment_no" label="支付编号" />
      <el-table-column prop="user.nickname" label="用户" align="center" />
      <el-table-column prop="payment_price" label="支付金额" align="center" sortable="custom" />
      <el-table-column prop="status" label="支付状态" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-button
            v-if="scope.row.status == 10"
            size="mini"
            type="info"
          >未支付</el-button>
          <el-button
            v-if="scope.row.status == 20"
            size="mini"
            type="success"
          >已支付</el-button>
        </template>
      </el-table-column>
      <el-table-column prop="payment_time" label="支付时间" align="center" sortable="custom" />
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
import { list } from '@/api/finance/payment'
import Pagination from '@/components/Pagination'

export default {
  name: 'FinancePayment',
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

<style>
.table-expand {
  font-size: 0;
}
.table-expand label {
  width: 90px;
  color: #99a9bf;
}
.table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 100%;
}
</style>
