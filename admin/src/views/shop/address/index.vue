<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="自提点名称"
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
        @click="$router.push('/shop/address/add')"
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
          <el-form label-position="left" class="table-expand">
            <el-form-item label="地址名称">
              <span>{{ props.row.address_name }}</span>
            </el-form-item>
            <el-form-item label="联系电话">
              <span>{{ props.row.phone }}</span>
            </el-form-item>
            <el-form-item label="营业时间">
              <span>{{ props.row.business == 10 ? '全天' : props.row.business_begin + '-' + props.row.business_end }}</span>
            </el-form-item>
            <el-form-item label="城市">
              <span>{{ props.row.province }}{{ props.row.city }}{{ props.row.district }}</span>
            </el-form-item>
            <el-form-item label="详细地址">
              <span>{{ props.row.address }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column prop="address_name" label="地址名称" />
      <el-table-column prop="phone" label="联系电话" align="center" />
      <el-table-column prop="city" label="城市" align="center" />
      <el-table-column label="营业时间" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.business == 10">
            全天
          </section>
          <section v-else>
            {{ scope.row.business_begin }} - {{ scope.row.business_end }}
          </section>
        </template>
      </el-table-column>
      <el-table-column label="地址类型" width="100" align="center">
        <template slot-scope="scope">
          <!-- 推荐 -->
          <div style="line-height: 30px;">
            <el-tag v-if="scope.row.is_fetch == 20">自提点</el-tag>
            <el-tag v-if="scope.row.is_shipment == 20" type="success">发货点</el-tag>
          </div>
        </template>
      </el-table-column>
      <el-table-column prop="sort" label="排序" align="center" sortable="custom" />
      <el-table-column prop="status" label="启用" align="center" sortable="custom">
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
            @click="$router.push('/shop/address/edit/' + scope.row.id)"
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
import { list, doStatus, doRemove } from '@/api/shop/address'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'ShopAddress',
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

<style>
/*  */
</style>
