<template>
  <div class="app-container">
    <el-page-header content="佣金信息" @back="$router.push('/user')" />
    <el-divider />
    <!-- 查询 -->
    <!-- <div class="filter-container">
      <el-select
        v-model="query.intro"
        placeholder="类型"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in introOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
    </div>
    <el-divider /> -->

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
      <el-table-column prop="amount" label="金额" sortable="custom" align="center" />
      <el-table-column prop="balance" label="余额" align="center" />
      <el-table-column prop="order.order_no" label="来自订单" align="center" />
      <el-table-column prop="from.nickname" label="来自用户" align="center" />
      <el-table-column prop="record_time" label="时间" sortable="custom" align="center" />
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
import { bonus } from '@/api/user/detail'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserDetailBonus',
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
      bonus(this.query)
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
