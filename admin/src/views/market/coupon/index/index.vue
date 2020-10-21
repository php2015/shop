<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.name"
        placeholder="优惠卷名称"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-select
        v-model="query.type"
        placeholder="类型"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in typeOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
      <el-select
        v-model="query.visible"
        placeholder="公开性"
        clearable
        style="width: 200px"
        class="filter-item"
      >
        <el-option
          v-for="item in visibleOptions"
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
        @click="$router.push('/market/coupon/add')"
      >添加</el-button>
      <el-button
        style="margin-left: 10px;"
        type="warning"
        icon="el-icon-s-ticket"
        @click="$router.push('/market/coupon/issue')"
      >发卷</el-button>
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
      <el-table-column prop="coupon_name" label="优惠卷名称" align="center" />
      <el-table-column label="规则" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.coupon_type == 10">
            <section v-if="scope.row.condition > 0">
              满{{ scope.row.condition }}减{{ scope.row.amount }}元
            </section>
            <section v-else>
              {{ scope.row.amount }}元无门槛
            </section>
          </section>
          <section v-if="scope.row.coupon_type == 20">
            <section v-if="scope.row.condition > 0">
              满{{ scope.row.condition }}打{{ scope.row.discount }}折
            </section>
            <section v-else>
              打{{ scope.row.discount }}折无门槛
            </section>
          </section>
        </template>
      </el-table-column>
      <el-table-column label="有效期" align="center">
        <template slot-scope="scope">
          <span v-if="scope.row.expire_type == 10">
            领取{{ scope.row.expire_at }}天内有效
          </span>
          <span v-if="scope.row.expire_type == 20">
            <div>{{ scope.row.begin_at }}</div>
            <div>{{ scope.row.end_at }}</div>
          </span>
        </template>
      </el-table-column>
      <el-table-column label="已领取/发行量" align="center">
        <template slot-scope="scope">
          {{ scope.row.received }}/{{ scope.row.total == 0 ? '不限制' : scope.row.total }}
        </template>
      </el-table-column>
      <el-table-column prop="used" label="已使用" align="center" sortable="custom" />
      <el-table-column prop="coupon_visible" label="公开性" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.coupon_visible == 10" type="info" effect="dark">不公开</el-tag>
          <el-tag v-if="scope.row.coupon_visible == 20" type="success" effect="dark">公开</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="status" label="状态" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.status == 10" type="info" effect="dark">已失效</el-tag>
          <el-tag v-if="scope.row.status == 20" type="success" effect="dark">进行中</el-tag>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="180" align="center">
        <template slot-scope="scope">
          <el-link
            v-if="scope.row.coupon_visible == 20 && scope.row.status == 20"
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/market/coupon/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link
            v-if="scope.row.coupon_visible == 20 && scope.row.status == 20"
            type="primary"
            icon="el-icon-switch-button"
            @click="handleStatus(scope.row.id)"
          >结束</el-link>
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
import { list, doStatus, doRemove } from '@/api/market/coupon/index'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'MarketCoupon',
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
      typeOptions: [
        {
          value: 10,
          label: '满减卷'
        },
        {
          value: 20,
          label: '折扣卷'
        }
      ],
      visibleOptions: [
        {
          value: 10,
          label: '不公开'
        },
        {
          value: 20,
          label: '公开'
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

    handleStatus (id) {
      this.$confirm('确认结束后，将停止发行该卷，已领取的优惠卷可继续使用', '系统提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.loading = true
          doStatus(id)
            .then(res => {
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
        .catch(() => {})
    }
  }
}
</script>

<style scoped>
/*  */
</style>
