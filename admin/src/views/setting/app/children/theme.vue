<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.theme_name"
        placeholder="主题名称"
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
      <el-table-column prop="theme_name" label="主题名称" />
      <!-- <el-table-column label="是否默认主题">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.is_default == 10" effect="dark" type="info">否</el-tag>
          <el-tag v-if="scope.row.is_default == 20" effect="dark" type="success">是</el-tag>
        </template>
      </el-table-column> -->
      <el-table-column prop="sort" label="排序" sortable="custom" />
      <el-table-column prop="status" label="默认" align="center">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.is_default"
            active-color="#13ce66"
            :inactive-value="10"
            :active-value="20"
            @change="handleDefault(scope.row.id)"
          />
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="200">
        <template slot-scope="scope">
          <el-dropdown @command="handleCommand">
            <span class="el-dropdown-link">
              <i class="el-icon-arrow-down el-icon--left" />设计
            </span>
            <el-dropdown-menu slot="dropdown">
              <section v-for="item in scope.row.page" :key="item.id">
                <el-dropdown-item :command="item.id">
                  {{ item.page_name }}
                </el-dropdown-item>
              </section>
            </el-dropdown-menu>
          </el-dropdown>
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="id = scope.row.id, editVisible = true"
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
    <theme-add v-if="addVisible" :visible.sync="addVisible" title="添加" />
    <theme-edit v-if="editVisible" :id="id" :visible.sync="editVisible" title="编辑" />
  </div>
</template>

<script>
import { list, doDefault, doRemove } from '@/api/setting/theme'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'
import ThemeAdd from './theme/add'
import ThemeEdit from './theme/edit'

export default {
  name: 'SettingAppTheme',
  components: {
    Pagination,
    ThemeAdd,
    ThemeEdit
  },
  data () {
    return {
      addVisible: false,
      editVisible: false,
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

    handleDefault (id) {
      this.loading = true
      doDefault(id)
        .then(res => {
          this.getList()
        })
        .finally(() => {
          this.loading = false
        })
    },

    handleCommand (id) {
      this.$router.push('/setting/app/index/design/' + id)
    }
  }
}
</script>

<style scoped>
.el-dropdown-link {
  cursor: pointer;
  color: #409EFF;
}
.el-icon-arrow-down {
  font-size: 12px;
}
.demonstration {
  display: block;
  color: #8492a6;
  font-size: 14px;
  margin-bottom: 20px;
}
</style>
