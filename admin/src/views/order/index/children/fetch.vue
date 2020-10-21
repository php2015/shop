<template>
  <div>
    <!-- 查询 -->
    <div class="filter-container" style="line-height: 50px;">
      <div style="display: flex; align-items: center;">
        <section style="font-size: 14px; color: #606266; font-weight: bold;">订单状态：</section>
        <el-radio-group v-model="query.status">
          <el-radio-button :label="null">全部</el-radio-button>
          <el-radio-button :label="1">待付款</el-radio-button>
          <el-radio-button :label="2">待发货</el-radio-button>
          <el-radio-button :label="3">待收货</el-radio-button>
          <el-radio-button :label="0">已完成</el-radio-button>
        </el-radio-group>
      </div>
      <div style="display: flex; align-items: center;">
        <section style="font-size: 14px; color: #606266; font-weight: bold;">时间选择：</section>
        <el-radio-group v-model="query.date" @change="query.between = ''">
          <el-radio-button :label="null">全部</el-radio-button>
          <el-radio-button :label="0">今日</el-radio-button>
          <el-radio-button :label="1">昨日</el-radio-button>
          <el-radio-button :label="2">本周</el-radio-button>
          <el-radio-button :label="3">本月</el-radio-button>
          <el-radio-button :label="4">本年</el-radio-button>
        </el-radio-group>
      </div>
      <div style="display: flex; align-items: center;">
        <section style="font-size: 14px; color: #606266; font-weight: bold;">时间区间：</section>
        <el-date-picker
          v-model="query.between"
          value-format="timestamp"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          :picker-options="pickerOptions"
          @change="query.date = null"
        />
      </div>
      <div style="display: flex; align-items: center;">
        <section style="font-size: 14px; color: #606266; font-weight: bold;">查询条件：</section>
        <section style="padding-right: 10px;">
          <el-input
            v-model="query.order_no"
            placeholder="订单编号"
            style="width: 200px;"
            class="filter-item"
            clearable
            @keyup.enter.native="handleSearch"
          />
        </section>
        <el-button type="primary" icon="el-icon-search" class="filter-item" @click="handleSearch">搜索</el-button>
      </div>
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
          <div style="display: flex; justify-content: flex-start; flex-wrap: wrap;">
            <div v-for="item in props.row.goods" :key="item.id" class="order_goods">
              <el-card :body-style="{ padding: '0px' }">
                <img
                  :src="item.image_url"
                  class="image"
                >
                <div style="padding: 14px;">
                  <span class="order_goods_name">{{ item.goods_name }}{{ item.sku_name }}</span>
                  <div class="bottom clearfix">
                    <span class="price">￥{{ item.sales_price }}</span>
                    <span class="total">数量：{{ item.quantity }}</span>
                  </div>
                </div>
              </el-card>
            </div>
          </div>
        </template>
      </el-table-column>
      <el-table-column prop="order_no" label="订单编号" align="center" />
      <el-table-column prop="user.nickname" label="用户" align="center" />
      <el-table-column prop="payment_price" label="实付金额" align="center" sortable="custom" />
      <el-table-column prop="order_time" label="下单时间" align="center" sortable="custom" />
      <el-table-column label="订单状态" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.order_status.value == 1" type="info" effect="dark">待支付</el-tag>
          <el-tag v-if="scope.row.order_status.value == 2" type="warning" effect="dark">待发货</el-tag>
          <el-tag v-if="scope.row.order_status.value == 3" effect="dark">待收货</el-tag>
          <el-tag v-if="scope.row.order_status.value == 0" type="success" effect="dark">已完成</el-tag>
          <el-tag v-if="scope.row.order_status.value == -1" type="info" effect="dark">已关闭</el-tag>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-document"
            @click="$router.push('/order/detail/' + scope.row.id)"
          >详细</el-link>
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
import { list } from '@/api/order'
import Pagination from '@/components/Pagination'

export default {
  name: 'OrderListExpress',
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
        status: null,
        date: null,
        between: '',
        logistics_method: 30,
        sort: 'id:desc'
      },
      pickerOptions: {
        shortcuts: [{
          text: '最近一周',
          onClick (picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近一个月',
          onClick (picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近三个月',
          onClick (picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
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

<style>
.price {
  font-size: 13px;
  color: red;
}

.total {
  padding: 0;
  float: right;
  font-size: 13px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
}

.image {
  width: 100%;
  display: block;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}

.clearfix:after {
  clear: both;
}

.order_goods {
  width: 200px;
  padding: 0 20px 20px 0;
}

.order_goods_name {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}
</style>
