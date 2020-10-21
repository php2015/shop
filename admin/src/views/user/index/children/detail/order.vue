<template>
  <div class="app-container">
    <el-page-header content="订单信息" @back="$router.push('/user')" />
    <el-divider />
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.order_no"
        placeholder="订单编号"
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
      <el-table-column prop="id" label="ID" align="center" />
      <el-table-column prop="order_no" label="订单编号" align="center" />
      <el-table-column prop="payment_price" label="支付金额" sortable="custom" align="center" />
      <el-table-column prop="order_time" label="下单时间" sortable="custom" align="center" />
      <el-table-column label="物流方式" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.logistics_method == 10" type="success" effect="dark">快递发货</el-tag>
          <el-tag v-if="scope.row.logistics_method == 20" type="primary" effect="dark">同城配送</el-tag>
          <el-tag v-if="scope.row.logistics_method == 30" type="warning" effect="dark">上门自提</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="状态" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.order_status.value == 1" type="info" effect="dark">待支付</el-tag>
          <el-tag v-if="scope.row.order_status.value == 2" type="warning" effect="dark">待发货</el-tag>
          <el-tag v-if="scope.row.order_status.value == 3" effect="dark">待收货</el-tag>
          <el-tag v-if="scope.row.order_status.value == 0" type="success" effect="dark">已完成</el-tag>
          <el-tag v-if="scope.row.order_status.value == -1" type="info" effect="dark">已关闭</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="invoice_status" label="发票信息" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.invoice_status == 10" type="info" effect="dark">不开票</el-tag>
          <el-tag v-if="scope.row.invoice_status == 20" type="success" effect="dark">开票</el-tag>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-document"
            @click="$router.push('/order/detail/' + scope.row.id)"
          >详细</el-link>
          <el-link
            v-if="scope.row.order_status.value == 20"
            type="primary"
            icon="el-icon-box"
            @click="$router.push('/order/shipment/' + scope.row.id)"
          >发货</el-link>
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
import { order } from '@/api/user/detail'
import Pagination from '@/components/Pagination'

export default {
  name: 'UserDetailOrder',
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
        id: this.$route.params.id,
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
      order(this.query)
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
