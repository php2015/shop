<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-select
        v-model="query.category"
        placeholder="分类"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in category"
          :key="item.value"
          :label="item.category_name"
          :value="item.id"
        />
      </el-select>
      <el-input
        v-model="query.contact"
        placeholder="联系人"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-input
        v-model="query.content"
        placeholder="反馈内容"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <!-- <span v-show="expert">
        <el-input
          v-model="query.content"
          placeholder="反馈内容"
          style="width: 200px;"
          class="filter-item"
          clearable
          @keyup.enter.native="handleSearch"
        />
      </span> -->
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
      <!-- <el-checkbox v-model="expert" class="expert">高级搜索</el-checkbox> -->
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
      <el-table-column prop="category.category_name" label="分类名称" align="center" />
      <el-table-column prop="contact" label="联系人" align="center" />
      <el-table-column prop="content" label="反馈内容" align="center" />
      <el-table-column prop="feedback_time" label="反馈时间" align="center" sortable="custom" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
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
  </div>
</template>

<script>
import { init, list, doRemove } from '@/api/user/feedback'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserFeedback',
  components: { Pagination },
  data () {
    return {
      loading: false,
      expert: false,
      list: null,
      category: null,
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
    this.loading = true
    init(this.query)
      .then(res => {
        const result = res.data
        this.category = result.category
        this.list = result.list.data
        this.total = result.list.total
        this.page_total = result.list.last_page
      })
      .finally(() => {
        this.loading = false
      })
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
