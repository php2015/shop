<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.cash_no"
        placeholder="提现编号"
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
      stripe
      border
      :data="list"
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left" class="table-expand">
            <el-form-item label="用户">
              <span>{{ props.row.user.nickname }}</span>
            </el-form-item>
            <el-form-item label="提现编号">
              <span>{{ props.row.cash_no }}</span>
            </el-form-item>
            <el-form-item label="提现金额">
              <span>{{ props.row.cash_apply }}</span>
            </el-form-item>
            <el-form-item label="手续费">
              <span>{{ props.row.cash_fee }}</span>
            </el-form-item>
            <el-form-item label="到帐金额">
              <span>{{ props.row.cash_amount }}</span>
            </el-form-item>
            <el-form-item label="客户端IP">
              <span>{{ props.row.client_ip }}</span>
            </el-form-item>
            <el-form-item label="提现时间">
              <span>{{ props.row.cash_time }}</span>
            </el-form-item>
            <el-form-item label="提现状态">
              <span v-if="props.row.cash_status == 10" style="color:#909399">申请中...</span>
              <span v-else style="color:#67C23A">已完成</span>
            </el-form-item>
            <section v-if="props.row.cash_status == 20">
              <el-form-item label="完成时间">
                <span>{{ props.row.finish_time }}</span>
              </el-form-item>
              <el-form-item label="审核结果">
                <span v-if="props.row.audit_status == 10" style="color:#F56C6C">已拒绝</span>
                <span v-else style="color:#67C23A">已通过</span>
              </el-form-item>
              <el-form-item label="审核结论">
                <span>{{ props.row.remark == '' ? '未填写' : props.row.remark }}</span>
              </el-form-item>
            </section>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column prop="cash_no" label="提现编号" />
      <el-table-column prop="cash_apply" label="提现金额" align="center" sortable="custom" />
      <el-table-column prop="cash_fee" label="手续费" align="center" sortable="custom" />
      <el-table-column prop="cash_amount" label="到帐金额" align="center" sortable="custom" />
      <el-table-column prop="cash_time" label="提现时间" align="center" sortable="custom" />
      <el-table-column v-if="status == 0" fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/finance/cash/audit/' + scope.row.id)"
          >审核</el-link>
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
import { list } from '@/api/finance/cash'
import Pagination from '@/components/Pagination'

export default {
  name: 'FinanceCashList',
  components: { Pagination },
  props: {
    status: {
      type: Number,
      default: 0
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
        cash_no: '',
        status: this.status,
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
