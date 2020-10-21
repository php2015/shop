<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="分组名称"
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
        @click="$router.push('/goods/group/add')"
      >添加</el-button>
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
      <el-table-column prop="id" label="ID" align="center" />
      <el-table-column prop="group_name" label="名称" align="center" />
      <el-table-column prop="goods_count" label="关联商品数量" align="center" />
      <el-table-column prop="sort" label="排序" align="center" sortable="custom" />
      <el-table-column prop="status" label="状态" align="center">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.status"
            active-color="#13ce66"
            :inactive-value="10"
            :active-value="20"
            @change="handleStatus(scope, 'status')"
          />
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="280" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/goods/group/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { list, doStatus, doRemove } from '@/api/goods/group'
import { batchHandle } from '@/utils'

export default {
  name: 'GoodsGroup',
  data () {
    return {
      loading: false,
      expand_all: false,
      list: null,
      query: {
        page: 1,
        limit: 10,
        sort: 'sort:asc'
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

    handleStatus (scope, field) {
      this.loading = true
      doStatus(scope.row.id, field)
        .then(res => {})
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<style>
/* ... */
</style>
