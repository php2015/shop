<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="规格名称"
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
        @click="$router.push('/goods/spec/add')"
      >添加</el-button>
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
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-tag
            v-for="(item, index) in props.row.value"
            :key="index"
            closable
            :disable-transitions="false"
            @close="removeValue(index, item, props)"
          >{{ item.name }}</el-tag>
          <el-input
            ref="tags"
            v-model="props.row.text"
            :data-id="props.row.id"
            class="input-new-tag"
            placeholder="回车添加"
            clearable
            @keyup.enter.native="addValue(props)"
          />
        </template>
      </el-table-column>
      <el-table-column prop="name" label="规格名称" />
      <el-table-column prop="sort" label="排序" align="center" sortable="custom" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/goods/spec/edit/' + scope.row.id)"
          >编辑</el-link>
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
import { list, doRemove, doAddValue, doRemoveValue } from '@/api/goods/spec'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'GoodsSpec',
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
          const list = res.data.data
          list.forEach(item => {
            item.text = ''
          })
          this.list = list
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

    addValue (scope) {
      // const inputValue = this.inputValue
      if (scope.row.text) {
        doAddValue({
          spec_id: scope.row.id,
          name: scope.row.text
        }).then(res => {
          this.$message({
            message: res.msg,
            type: 'success'
          })
          scope.row.value.push({
            id: res.data.id,
            name: scope.row.text,
            spec_id: scope.row.id
          })
          scope.row.text = ''
        })
      }
    },

    removeValue (index, item, scope) {
      batchHandle(item.id).then(id => {
        this.loading = true
        doRemoveValue(id).then(res => {
          this.$message({
            message: res.msg,
            type: 'success'
          })
          scope.row.value.splice(index, 1)
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
.el-tag + .el-tag {
  margin-left: 10px;
}
.button-new-tag {
  margin-left: 10px;
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
.input-new-tag {
  width: 120px;
  margin-left: 10px;
}
</style>
