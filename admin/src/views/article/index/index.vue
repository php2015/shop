<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.title"
        placeholder="文章标题"
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
        @click="$router.push('/article/index/add')"
      >添加</el-button>
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
      :data="list"
      stripe
      border
      highlight-current-row
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column fixed type="selection" width="55" />
      <el-table-column label="图片" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 100px; height: 60px"
            :src="scope.row.image_url"
            :preview-src-list="[scope.row.image_url]"
          />
        </template>
      </el-table-column>
      <el-table-column prop="category.category_name" label="文章分类" align="center" />
      <el-table-column prop="title" label="文章标题" align="center" />
      <el-table-column prop="views" label="点击量" align="center" sortable="custom" />
      <el-table-column prop="release_time" label="发布时间" align="center" sortable="custom" />
      <el-table-column label="推荐" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.is_best"
            active-color="#13ce66"
            :inactive-value="10"
            :active-value="20"
            @change="handleStatus(scope, 'is_best')"
          />
        </template>
      </el-table-column>
      <el-table-column label="状态" align="center" sortable="custom">
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
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/article/index/edit/' + scope.row.id)"
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
  </div>
</template>

<script>
import { list, doStatus, doRemove } from '@/api/article'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'Article',
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

<style scoped>
/*  */
</style>
