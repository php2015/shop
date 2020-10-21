<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.id"
        placeholder="ID"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-input
        v-model="query.nickname"
        placeholder="昵称"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-input
        v-model="query.city"
        placeholder="城市"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-select
        v-model="query.gender"
        placeholder="性别"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in genderOptions"
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
      :data="list"
      stripe
      border
      highlight-current-row
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column prop="id" label="ID" align="center" sortable="custom" />
      <el-table-column prop="avatar" label="头像" align="center">
        <template slot-scope="scope">
          <el-avatar :src="scope.row.avatar_url" />
        </template>
      </el-table-column>
      <el-table-column prop="nickname" label="昵称" align="center" />
      <el-table-column prop="gender" label="性别" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.gender == 0">未知</section>
          <section v-if="scope.row.gender == 1">男</section>
          <section v-if="scope.row.gender == 2">女</section>
        </template>
      </el-table-column>
      <el-table-column prop="city" label="城市" align="center" />
      <el-table-column prop="points" label="积分余额" align="center" sortable="custom" />
      <el-table-column prop="bonus" label="佣金余额" align="center" sortable="custom" />
      <el-table-column prop="register_time" label="注册时间" align="center" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-document"
            @click="$router.push('/user/detail/' + scope.row.id)"
          >详细</el-link>
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/user/edit/' + scope.row.id)"
          >编辑</el-link>
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
import { list } from '@/api/user/index'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserList',
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
      genderOptions: [
        {
          value: 1,
          label: '男'
        },
        {
          value: 2,
          label: '女'
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>
