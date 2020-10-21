<template>
  <div class="dashboard-container">
    <el-card v-loading="marketLoading" shadow="hover">
      <div slot="header" style="display: flex; justify-content: space-between; align-items: center;">
        <span>运营数据</span>
        <span style="float: right;">
          <el-button size="mini" :type="marketDate == 0 ? 'primary' : 'text'" @click="marketDate = 0">今日</el-button>
          <el-button size="mini" :type="marketDate == 1 ? 'primary' : 'text'" @click="marketDate = 1">昨日</el-button>
          <el-button size="mini" :type="marketDate == 2 ? 'primary' : 'text'" @click="marketDate = 2">本周</el-button>
          <el-button size="mini" :type="marketDate == 3 ? 'primary' : 'text'" @click="marketDate = 3">上周</el-button>
          <el-button size="mini" :type="marketDate == 4 ? 'primary' : 'text'" @click="marketDate = 4">本月</el-button>
          <el-button size="mini" :type="marketDate == 5 ? 'primary' : 'text'" @click="marketDate = 5">上月</el-button>
        </span>
      </div>
      <div>
        <el-row class="home-market">
          <!-- 1 -->
          <el-col :span="8" style="border-right:1px solid #efefef">
            <!-- 访问 -->
            <el-row>
              <el-col v-if="market1.pv" :span="8">
                <!-- 访问次数 -->
                <div class="home-market-count">{{ market1.pv.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market1.pv.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market1.pv.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market1.pv.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">访问次数</div>
              </el-col>
              <el-col v-if="market1.order" :span="8">
                <!-- 新增订单数 -->
                <div class="home-market-count">{{ market1.order.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market1.order.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market1.order.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market1.order.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">新增订单数</div>
              </el-col>
              <el-col v-if="market1" :span="8">
                <!-- 访问 - 支付转化率 -->
                <div class="home-market-count">{{ market1.pc }}%</div>
                <div class="home-market-percentage" />
                <div class="home-market-title">转化率</div>
              </el-col>
            </el-row>
          </el-col>
          <!-- 2 -->
          <el-col :span="8" style="border-right:1px solid #efefef">
            <!-- 支付 -->
            <el-row>
              <el-col v-if="market2.amount" :span="8">
                <!-- 支付金额 -->
                <div class="home-market-count">{{ market2.amount.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market2.amount.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market2.amount.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market2.amount.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">支付金额</div>
              </el-col>
              <el-col v-if="market2.user" :span="8">
                <!-- 下单用户数 -->
                <div class="home-market-count">{{ market2.user.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market2.user.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market2.user.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market2.user.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">下单用户数</div>
              </el-col>
              <el-col v-if="market2.up" :span="8">
                <!-- 客单价 -->
                <div class="home-market-count">{{ market2.up.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market2.up.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market2.up.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market2.up.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">客单价</div>
              </el-col>
            </el-row>
          </el-col>
          <!-- 3 -->
          <el-col :span="8">
            <!-- 用户 -->
            <el-row>
              <el-col v-if="market3.new" :span="12">
                <!-- 新增用户数 -->
                <div class="home-market-count">{{ market3.new.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market3.new.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market3.new.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market3.new.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">新增用户数</div>
              </el-col>
              <el-col v-if="market3.old" :span="12">
                <!-- 老用户活跃数 -->
                <div class="home-market-count">{{ market3.old.current }}</div>
                <div class="home-market-percentage">
                  <span>同比</span>
                  <span :style="{'color': market3.old.percentage >=0 ? 'green' : 'red'}">
                    <i :class="[market3.old.percentage >=0 ? 'el-icon-caret-top' : 'el-icon-caret-bottom']" />{{ market3.old.percentage }}%
                  </span>
                </div>
                <div class="home-market-title">老用户活跃数</div>
              </el-col>
            </el-row>
          </el-col>
        </el-row>
      </div>
    </el-card>

    <el-row :gutter="10" style="padding-top: 5px;">
      <el-col :span="14">
        <!-- 新订单 -->
        <el-card v-loading="orderLoading" shadow="hover">
          <!-- <div slot="header">
            <span>新订单</span>
            <el-button style="float: right; padding: 3px 0" type="text">去处理</el-button>
          </div> -->
          <div style="padding-bottom: 5px">新订单</div>
          <div style="min-height: 200px">
            <el-table :data="order" height="200">
              <el-table-column prop="order_no" label="编号" align="center" />
              <el-table-column label="配送方式" align="center">
                <template slot-scope="scope">
                  <section v-if="scope.row.logistics_method == 10">快递发货</section>
                  <section v-if="scope.row.logistics_method == 20">同城配送</section>
                  <section v-if="scope.row.logistics_method == 30">上门自提</section>
                </template>
              </el-table-column>
              <el-table-column prop="order_time" label="下单时间" align="center" />
            </el-table>
          </div>
        </el-card>
        <!-- 分销商申请 -->
        <el-card v-loading="distributionLoading" shadow="hover" style="margin-top: 5px;">
          <div style="padding-bottom: 5px">分销商申请</div>
          <div style="min-height: 200px">
            <el-table :data="distribution" height="200">
              <el-table-column prop="name" label="姓名" align="center" />
              <el-table-column prop="phone" label="手机号" align="center" />
              <el-table-column prop="apply_time" label="申请时间" align="center" />
            </el-table>
          </div>
        </el-card>
        <!-- 提现申请 -->
        <el-card v-loading="cashLoading" shadow="hover" style="margin-top: 5px;">
          <div style="padding-bottom: 5px">提现申请</div>
          <div style="min-height: 200px">
            <el-table :data="cash" height="200">
              <el-table-column prop="cash_no" label="编号" align="center" />
              <el-table-column prop="cash_apply" label="提现金额" align="center" />
              <el-table-column prop="cash_time" label="申请时间" align="center" />
            </el-table>
          </div>
        </el-card>
      </el-col>
      <el-col :span="10">
        <!-- 商品销量排行 -->
        <el-card v-loading="goodsLoading" shadow="hover">
          <div slot="header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>商品销量排行</span>
            <span style="float: right;">
              <el-button size="mini" :type="goodsDate == 0 ? 'primary' : 'text'" @click="goodsDate = 0">今日</el-button>
              <el-button size="mini" :type="goodsDate == 1 ? 'primary' : 'text'" @click="goodsDate = 1">昨日</el-button>
              <el-button size="mini" :type="goodsDate == 2 ? 'primary' : 'text'" @click="goodsDate = 2">本周</el-button>
              <el-button size="mini" :type="goodsDate == 3 ? 'primary' : 'text'" @click="goodsDate = 3">上周</el-button>
              <el-button size="mini" :type="goodsDate == 4 ? 'primary' : 'text'" @click="goodsDate = 4">本月</el-button>
              <el-button size="mini" :type="goodsDate == 5 ? 'primary' : 'text'" @click="goodsDate = 5">上月</el-button>
            </span>
          </div>
          <div style="min-height: 700px;">
            <div v-for="(item, index) in goods" :key="item.goods_id" class="top-index">
              <div class="top-index-num" :class="{'top-index-num-1': index==0,'top-index-num-2': index==1,'top-index-num-3': index==2}">
                {{ index + 1 }}
              </div>
              <div style="padding-left: 10px;">
                {{ item.goods.goods_name }}
              </div>
            </div>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { market, order, distribution, cash, goods } from '@/api/dashboard'

export default {
  name: 'Dashboard',
  components: {},
  data () {
    return {
      marketLoading: false,
      marketDate: 0,
      market: [],
      market1: {},
      market2: {},
      market3: {},
      orderLoading: false,
      order: [],
      distributionLoading: false,
      distribution: [],
      cashLoading: false,
      cash: [],
      goodsDate: 0,
      goodsLoading: false,
      goods: []
    }
  },
  watch: {
    marketDate: {
      immediate: true,
      handler (value) {
        this.marketChange()
      }
    },
    market (value) {
      this.market1 = value[0]
      this.market2 = value[1]
      this.market3 = value[2]
    },
    property: {
      immediate: true,
      handler (value) {
        this.orders()
        this.distributions()
        this.cashs()
      }
    },
    goodsDate: {
      immediate: true,
      handler (value) {
        this.goodsTop()
      }
    }
  },
  created () { },
  methods: {
    marketChange () {
      this.marketLoading = true
      market(this.marketDate)
        .then(res => {
          const { data } = res
          this.market = data
        })
        .finally(() => {
          this.marketLoading = false
        })
    },
    orders () {
      this.orderLoading = true
      order()
        .then(res => {
          const { data } = res
          this.order = data
        })
        .finally(() => {
          this.orderLoading = false
        })
    },
    distributions () {
      this.distributionLoading = true
      distribution()
        .then(res => {
          const { data } = res
          this.distribution = data
        })
        .finally(() => {
          this.distributionLoading = false
        })
    },
    cashs () {
      this.cashLoading = true
      cash()
        .then(res => {
          const { data } = res
          this.cash = data
        })
        .finally(() => {
          this.cashLoading = false
        })
    },
    goodsTop () {
      this.goodsLoading = true
      goods(this.goodsDate)
        .then(res => {
          const { data } = res
          this.goods = data
        })
        .finally(() => {
          this.goodsLoading = false
        })
    }
  }
}
</script>

<style scoped>
.home-market {
  text-align: center;
}
.home-market div {
  line-height: 25px;
}
.home-market-count {
  font-size: 28px;
}
.home-market-percentage {
  min-height: 25px;
  font-size: 10px;
  color: #909399;
}
.home-market-title {
  font-size: 14px;
  font-weight: bold;
  color: #909399;
}
.top-index {
  display: flex;
  padding-bottom: 15px;
}
.top-index-num {
  width: 20px;
  height: 20px;
  line-height: 20px;;
  color: #fff;
  text-align: center;
  border-radius:50%;
  background: #909399;
  font-size: 12px;
}
.top-index-num-1 {
  background: #F56C6C;
}
.top-index-num-2 {
  background: #E6A23C;
}
.top-index-num-3 {
  background: #67C23A;
}
</style>

<style lang="scss" scoped>
.dashboard-container {
  padding: 20px;
  background-color: rgb(240, 242, 245);
  // background: #fff;
  position: relative;
  height: 100%;

  .github-corner {
    position: absolute;
    top: 0px;
    border: 0;
    right: 0;
  }

  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}

@media (max-width: 1024px) {
  .chart-wrapper {
    padding: 8px;
  }
}
</style>
