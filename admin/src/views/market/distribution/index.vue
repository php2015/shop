<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="姓名"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-input
        v-model="query.phone"
        placeholder="手机号"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
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
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column type="expand">
        <template slot-scope="scope">
          <el-form label-position="left" class="table-expand">
            <el-form-item label="姓名">
              <span>{{ scope.row.name }}</span>
            </el-form-item>
            <el-form-item label="手机号">
              <span>{{ scope.row.phone }}</span>
            </el-form-item>
            <el-form-item label="关联用户">
              <span>{{ scope.row.user.nickname }}</span>
            </el-form-item>
            <el-form-item label="申请时间">
              <span>{{ scope.row.apply_time }}</span>
            </el-form-item>
            <el-form-item label="申请状态">
              <span v-if="scope.row.apply_status == 10" style="color:#909399">申请中...</span>
              <span v-else style="color:#67C23A">已完成</span>
            </el-form-item>
            <section v-if="scope.row.apply_status == 20">
              <el-form-item label="审核时间">
                <span>{{ scope.row.audit_time }}</span>
              </el-form-item>
              <el-form-item label="审核结果">
                <span v-if="scope.row.audit_status == 10" style="color:#F56C6C">已拒绝</span>
                <span v-else style="color:#67C23A">已通过</span>
              </el-form-item>
              <el-form-item label="审核结论">
                <span>{{ scope.row.remark == '' ? '未填写' : scope.row.remark }}</span>
              </el-form-item>
            </section>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column prop="name" label="姓名" align="center" />
      <el-table-column prop="phone" label="手机号" align="center" />
      <el-table-column prop="user.nickname" label="关联用户" align="center" />
      <el-table-column label="申请状态" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.apply_status == 10" type="info" effect="dark">申请中</el-tag>
          <el-tag v-if="scope.row.apply_status == 20" type="success" effect="dark">已完成</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="申请结果" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.audit_status == 10" type="info" effect="dark">未通过</el-tag>
          <el-tag v-if="scope.row.audit_status == 20" type="success" effect="dark">已通过</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="remark" label="备注信息" align="center" />
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            v-if="scope.row.apply_status == 10"
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/market/distribution/auth/' + scope.row.id)"
          >审核</el-link>
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
import { list } from '@/api/market/distribution'
import Pagination from '@/components/Pagination'

export default {
  name: 'MarketDistribution',
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>
