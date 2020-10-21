<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="优惠卷名称"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-select
        v-model="query.type"
        placeholder="类型"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in typeOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
      <el-select
        v-model="query.status"
        placeholder="状态"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in statusOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
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
      <el-table-column prop="user.nickname" label="用户" align="center" />
      <el-table-column prop="coupon_name" label="优惠卷名称" align="center" />
      <el-table-column label="规则" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.coupon_type == 10">
            <section v-if="scope.row.condition > 0">
              满{{ scope.row.condition }}减{{ scope.row.amount }}元
            </section>
            <section v-else>
              {{ scope.row.amount }}元无门槛
            </section>
          </section>
          <section v-if="scope.row.coupon_type == 20">
            <section v-if="scope.row.condition > 0">
              满{{ scope.row.condition }}打{{ scope.row.discount }}折
            </section>
            <section v-else>
              打{{ scope.row.discount }}折无门槛
            </section>
          </section>
        </template>
      </el-table-column>
      <el-table-column prop="expire_at" label="有效期至" align="center" sortable="custom" />
      <el-table-column label="来源" align="center">
        <template slot-scope="scope">
          {{ scope.row.source == '10' ? '主动领取' : '系统发放' }}
        </template>
      </el-table-column>
      <el-table-column prop="receive_at" label="领取时间" align="center" sortable="custom" />
      <el-table-column label="使用状态" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.status == 10" type="info" effect="dark">未使用</el-tag>
          <el-tag v-if="scope.row.status == 20" type="success" effect="dark">已使用</el-tag>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
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
import { list, doRemove } from '@/api/market/coupon/receive'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'MarketCouponReceive',
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
      },
      typeOptions: [
        {
          value: 10,
          label: '满减卷'
        },
        {
          value: 20,
          label: '折扣卷'
        }
      ],
      statusOptions: [
        {
          value: 10,
          label: '未使用'
        },
        {
          value: 20,
          label: '已使用'
        }
      ]
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>
