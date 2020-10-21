<template>
  <div class="app-container">
    <el-page-header content="优惠卷信息" @back="$router.push('/user')" />
    <el-divider />
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
      <el-button
        style="margin-left: 10px;"
        type="danger"
        icon="el-icon-delete"
        @click="handleRemove"
      >删除</el-button>
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
      <el-table-column fixed type="selection" width="55" />
      <el-table-column prop="coupon_name" label="优惠卷名称" />
      <el-table-column prop="coupon_type" label="优惠卷类型" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.coupon_type == 10" type="primary" effect="dark">满减卷</el-tag>
          <el-tag v-if="scope.row.coupon_type == 20" type="warning" effect="dark">折扣卷</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="优惠方式">
        <template slot-scope="scope">
          <span v-if="scope.row.coupon_type == 10">
            立减 {{ scope.row.amount }} 元
          </span>
          <span v-if="scope.row.coupon_type == 20">
            {{ scope.row.discount }} 折
          </span>
        </template>
      </el-table-column>
      <el-table-column prop="condition" label="最低消费金额" sortable="custom" align="center" />
      <el-table-column prop="expire_at" label="有效期至" sortable="custom" align="center" />
      <el-table-column prop="receive_at" label="领取时间" sortable="custom" align="center" />
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
import { coupon } from '@/api/user/detail'
import { doRemove } from '@/api/user/coupon'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserDetailCoupon',
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
      coupon(this.query)
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
