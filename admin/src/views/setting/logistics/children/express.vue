<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="模板名称"
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
        @click="addVisible = true"
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
      <el-table-column prop="name" label="模板名称" align="center" />
      <el-table-column label="是否包邮" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.free == 10" type="info" effect="dark">不包邮</el-tag>
          <el-tag v-if="scope.row.free == 20" type="success" effect="dark">包邮</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="计价方式" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.method == 10" type="primary" effect="dark">按件数</el-tag>
          <el-tag v-if="scope.row.method == 20" type="warning" effect="dark">按重量</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="sort" label="排序" align="center" sortable="custom" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="id = scope.row.id, editVisible = true"
          >编辑</el-link>
          <el-link
            type="danger"
            icon="el-icon-delete"
            @click="handleRemove(scope.row.id)"
          >删除</el-link>
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
    <express-add v-if="addVisible" :visible.sync="addVisible" title="添加" />
    <express-edit v-if="editVisible" :id="id" :visible.sync="editVisible" title="编辑" />
  </div>
</template>

<script>
import { list, doRemove } from '@/api/setting/logistics/express'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'
import ExpressAdd from './express/add'
import ExpressEdit from './express/edit'

export default {
  name: 'SettingLogisticsExpress',
  components: {
    Pagination,
    ExpressAdd,
    ExpressEdit
  },
  data () {
    return {
      addVisible: false,
      editVisible: false,
      loading: false,
      list: null,
      id: null,
      total: 0,
      page_total: 0,
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>
