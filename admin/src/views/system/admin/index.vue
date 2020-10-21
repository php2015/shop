<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.username"
        placeholder="用户名"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-select
        v-model="query.disable"
        placeholder="状态"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in disableOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
      <el-button
        style="margin-left: 10px;"
        type="success"
        icon="el-icon-edit-outline"
        @click="$router.push('/system/admin/add')"
      >添加</el-button>
      <el-button
        style="margin-left: 10px;"
        type="danger"
        icon="el-icon-delete"
        @click="handleRemove"
      >删除</el-button>
      <el-checkbox style="margin-left:15px;">高级搜索</el-checkbox>
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
      <el-table-column fixed type="selection" width="55" align="center" :selectable="handleDisable" />
      <el-table-column prop="username" label="用户名" align="center" sortable="custom" />
      <el-table-column prop="role.role_name" label="所属角色" align="center" />
      <el-table-column prop="realname" label="姓名" align="center" />
      <el-table-column prop="email" label="邮箱" align="center" />
      <el-table-column prop="phone" label="手机号" align="center" />
      <el-table-column label="状态" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.disable == 10" type="success" effect="dark">正常</el-tag>
          <el-tag v-if="scope.row.disable == 20" type="info" effect="dark">禁用</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="last_login_time" label="最后登录时间" align="center" sortable="custom" />
      <el-table-column prop="last_login_ip" label="最后登录IP" align="center" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/system/admin/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link
            v-if="scope.row.id !== 10000"
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
    <!-- Dialog -->
    <!-- <AccountEdit v-if="editVisible" :id="id" :visible.sync="editVisible" title="编辑账户" /> -->
  </div>
</template>

<script>
import { list, doRemove } from '@/api/system/admin'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'Admin',
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
        sort: 'id:asc'
      },
      disableOptions: [
        {
          value: 20,
          label: '正常'
        },
        {
          value: 10,
          label: '禁用'
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
        this.query.sort = 'id:asc'
        this.handleSearch()
      }
    },

    handleSearch () {
      this.query.page = 1
      this.getList()
    },

    handleDisable (row, index) {
      if (row.id === 10000) {
        return false
      }
      return true
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
