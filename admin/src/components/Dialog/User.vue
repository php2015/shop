<template>
  <div>
    <el-dialog title="选择用户" :visible.sync="visible" :before-close="beforeClose" :destroy-on-close="true" width="80%">
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
        <el-button v-if="!radio" type="success" icon="el-icon-circle-check" @click="handleSubmit">确定</el-button>
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
        @current-change="currentChange"
      >
        <el-table-column v-if="!radio" fixed type="selection" width="55" align="center" :selectable="handleDisable" />
        <el-table-column prop="id" label="ID" align="center" />
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
        <el-table-column prop="register_time" label="注册时间" align="center" />
      </el-table>
      <!-- 分页 -->
      <pagination
        v-show="page_total > 1"
        :total="total"
        :page.sync="query.page"
        :limit.sync="query.limit"
        @pagination="getList"
      />
    </el-dialog>
  </div>
</template>

<script>
import { user } from '@/api/dialog/index'
import Pagination from '@/components/Pagination'

export default {
  name: 'DialogUser',
  components: {
    Pagination
  },
  mixins: [],
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    params: {
      type: Array,
      default: () => []
    },
    radio: {
      type: Boolean,
      default: false
    }
  },
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
  computed: {},
  watch: {
    property: {
      immediate: true,
      handler (value) {
        this.getList()
      }
    }
  },
  created () {},
  methods: {
    getList () {
      this.loading = true
      user(this.query)
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

    currentChange (event) {
      this.$emit('change', [{
        id: event.id,
        image: event.avatar_url
      }])
      this.beforeClose()
    },

    handleSearch () {
      this.query.page = 1
      this.getList()
    },

    handleDisable (row, index) {
      const id = []
      this.params.forEach(item => {
        id.push(item.id)
      })
      if (id.indexOf(row.id) >= 0) {
        return false
      }
      return true
    },

    handleSubmit () {
      const data = this.$refs.table.selection
      const result = []

      if (data.length === 0) {
        this.$message.warning('至少选择一条数据')
        return false
      }
      if (this.radio && data.length > 1) {
        this.$message.warning('只能选择一条数据')
        return false
      }
      if (data.length > 0) {
        data.forEach(item => {
          result.push(
            {
              id: item.id,
              image: item.avatar_url
            }
          )
        })
        this.$emit('change', result)
        this.beforeClose()
      } else {
        this.$message.warning('至少选择一条数据')
      }
    },

    beforeClose () {
      this.$emit('update:visible', false)
    }
  }
}
</script>

<style>
/*  */
</style>
