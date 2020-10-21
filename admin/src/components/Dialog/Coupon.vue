<template>
  <div>
    <el-dialog title="选择商品" :visible.sync="visible" :before-close="beforeClose" :destroy-on-close="true" width="80%">
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
        <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
        <el-button type="success" icon="el-icon-circle-check" @click="handleSubmit">确定</el-button>
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
        <el-table-column fixed type="selection" width="55" :selectable="handleDisable" />
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
import { coupon } from '@/api/dialog/index'
import Pagination from '@/components/Pagination'

export default {
  name: 'DialogCoupon',
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
      typeOptions: [
        {
          value: 10,
          label: '满减卷'
        },
        {
          value: 20,
          label: '折扣卷'
        }
      ]
    }
  },
  computed: {},
  watch: {},
  created () {
    this.getList()
  },
  methods: {
    getList () {
      this.loading = true
      coupon(this.query)
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

      if (data.length > 0) {
        data.forEach(item => {
          result.push(
            {
              id: item.id,
              coupon_name: item.coupon_name,
              coupon_type: item.coupon_type,
              discount: item.discount,
              amount: item.amount,
              condition: item.condition
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
