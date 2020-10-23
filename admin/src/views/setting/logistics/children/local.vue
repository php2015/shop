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
      <!-- <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left" class="table-expand">
            <el-form-item label="门店名称">
              <span>{{ props.row.store_name }}</span>
            </el-form-item>
            <el-form-item label="负责人">
              <span>{{ props.row.contact }}</span>
            </el-form-item>
            <el-form-item label="联系电话">
              <span>{{ props.row.phone }}</span>
            </el-form-item>
            <el-form-item label="是否营业">
              <span v-if="props.row.status == 10" style="color:#909399">休息中</span>
              <span v-else style="color:#67C23A">营业中</span>
            </el-form-item>
            <el-form-item label="营业时间">
              <span>{{ props.row.business == 10 ? '全天' : props.row.business_begin + '-' + props.row.business_end }}</span>
            </el-form-item>
            <el-form-item label="城市">
              <span>{{ props.row.province }}{{ props.row.city }}{{ props.row.county }}</span>
            </el-form-item>
            <el-form-item label="详细地址">
              <span>{{ props.row.address }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column> -->
      <el-table-column prop="name" label="模板名称" />
      <el-table-column label="计价方式" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.method == 10" type="primary" effect="dark">按距离</el-tag>
          <el-tag v-if="scope.row.method == 20" type="warning" effect="dark">按重量</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="distance" label="最大可配送距离(km)" sortable="custom" />
      <el-table-column prop="weight" label="最大可配送重量(kg)" sortable="custom" />
      <el-table-column prop="sort" label="排序" sortable="custom" />
      <el-table-column fixed="right" label="操作" width="150">
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
    <local-add v-if="addVisible" :visible.sync="addVisible" title="添加" />
    <local-edit v-if="editVisible" :id="id" :visible.sync="editVisible" title="编辑" />
  </div>
</template>

<script>
import { list, doRemove } from '@/api/setting/logistics/local'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'
import LocalAdd from './local/add'
import LocalEdit from './local/edit'

export default {
  name: 'SettingLogisticsLocal',
  components: {
    Pagination,
    LocalAdd,
    LocalEdit
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
