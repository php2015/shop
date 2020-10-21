<template>
  <div v-loading="loading" class="app-container">
    <el-steps v-if="active > 0" :active="active">
      <el-step title="下单" icon="el-icon-shopping-cart-full" :description="detail.order_time" />
      <el-step title="支付" icon="el-icon-bank-card" :description="detail.payment_time" />
      <el-step title="发货" icon="el-icon-truck" :description="detail.logistics_time" />
      <el-step title="完成" icon="el-icon-finished" :description="detail.finish_time" />
    </el-steps>
    <el-steps v-if="active == 0" :active="4">
      <el-step title="下单" icon="el-icon-shopping-cart-full" :description="detail.order_time" />
      <el-step title="支付" icon="el-icon-bank-card" :description="detail.payment_time" />
      <el-step title="发货" icon="el-icon-truck" :description="detail.logistics_time" />
      <el-step title="完成" icon="el-icon-finished" :description="detail.finish_time" />
    </el-steps>
    <el-steps v-if="active == -1" :active="2">
      <el-step title="下单" icon="el-icon-shopping-cart-full" :description="detail.order_time" />
      <el-step title="关闭" icon="el-icon-close" :description="detail.close_time" />
      <el-step title="支付" icon="el-icon-bank-card" />
      <el-step title="发货" icon="el-icon-truck" />
      <el-step title="完成" icon="el-icon-finished" />
    </el-steps>
    <div style="padding-top: 20px;">
      <el-divider content-position="left" style="padding-top: 20px;">订单号：{{ detail.order_no }}</el-divider>
    </div>
    <div
      class="el-table el-table--border"
      style="width: 100%;"
    >
      <div class="el-table__header-wrapper">
        <table
          cellspacing="0"
          cellpadding="0"
          border="0"
          class="el-table__header"
          style="width: 100%;"
        >
          <thead class="has-gutter">
            <tr class>
              <th class="is-center">
                <div class="cell">用户</div>
              </th>
              <th class="is-center">
                <div class="cell">金额</div>
              </th>
              <th class="is-center">
                <div class="cell">备注</div>
              </th>
              <th class="is-center">
                <div class="cell">交易状态</div>
              </th>
            </tr>
          </thead>
          <td class="is-center">
            {{ detail.user && detail.user.nickname }}
          </td>
          <td style="line-height: 30px; padding-left: 20px;">
            <div>商品总额：￥{{ detail.goods_price }}</div>
            <div>运费金额：￥{{ detail.logistics_fee }}</div>
            <div>优惠金额：￥{{ detail.discount_price }}</div>
            <div>实际支付金额：￥{{ detail.payment_price }}</div>
          </td>
          <td style="line-height: 30px; padding-left: 20px;">
            <div>{{ detail.remark }}</div>
          </td>
          <td class="is-center" style="line-height: 30px;">
            <div>
              付款状态：
              <el-tag v-if="detail.payment_status == 10" type="info" effect="dark" size="small">待付款</el-tag>
              <el-tag v-if="detail.payment_status == 20" type="success" effect="dark" size="small">已付款</el-tag>
            </div>
            <div>
              发货状态：
              <el-tag v-if="detail.shipment_status == 10" type="info" effect="dark" size="small">待发货</el-tag>
              <el-tag v-if="detail.shipment_status == 20" type="success" effect="dark" size="small">已发货</el-tag>
            </div>
            <div>
              收货状态：
              <el-tag v-if="detail.receive_status == 10" type="info" effect="dark" size="small">待收货</el-tag>
              <el-tag v-if="detail.receive_status == 20" type="success" effect="dark" size="small">已收货</el-tag>
            </div>
          </td>
        </table>
      </div>
    </div>

    <!--  -->
    <el-divider content-position="left">商品信息</el-divider>
    <el-table ref="table" :data="goods" border style="width: 100%">
      <el-table-column label="商品图片" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 60px; height: 60px"
            :src="scope.row.image_url"
            :preview-src-list="[scope.row.image_url]"
          />
        </template>
      </el-table-column>
      <el-table-column label="商品名称" align="center">
        <template slot-scope="scope">
          {{ scope.row.goods_name }}{{ scope.row.sku_name }}
        </template>
      </el-table-column>
      <el-table-column label="商品单价" align="center">
        <template slot-scope="scope">￥{{ scope.row.sales_price }}</template>
      </el-table-column>
      <el-table-column prop="quantity" label="购买数量" align="center" />
      <el-table-column prop="total" label="小计" align="center" />
    </el-table>

    <section v-if="logistics">
      <el-divider content-position="left">物流信息</el-divider>
      <div
        class="el-table el-table--border"
        style="width: 100%;"
      >
        <div class="el-table__header-wrapper">
          <table
            cellspacing="0"
            cellpadding="0"
            border="0"
            class="el-table__header"
            style="width: 100%;"
          >
            <thead class="has-gutter">
              <tr class>
                <th class="is-center">
                  <div class="cell">联系人</div>
                </th>
                <th class="is-center">
                  <div class="cell">联系人电话</div>
                </th>
                <th class="is-center">
                  <div class="cell">收货地址</div>
                </th>
                <th class="is-center">
                  <div class="cell">物流公司</div>
                </th>
                <th class="is-center">
                  <div class="cell">快递单号</div>
                </th>
              </tr>
            </thead>
            <td class="is-center">
              {{ logistics.contact }}
            </td>
            <td class="is-center">
              {{ logistics.phone }}
            </td>
            <td class="is-center">
              {{ logistics.province }}{{ logistics.city }}{{ logistics.district }}{{ logistics.detail }}{{ logistics.num }}
            </td>
            <td class="is-center">
              {{ logistics.express && logistics.express.company }}
            </td>
            <td class="is-center">
              {{ logistics.express_no }}
            </td>
          </table>
        </div>
      </div>
    </section>

    <section v-if="fetch">
      <el-divider content-position="left">自提信息</el-divider>
      <div
        class="el-table el-table--border"
        style="width: 100%;"
      >
        <div class="el-table__header-wrapper">
          <table
            cellspacing="0"
            cellpadding="0"
            border="0"
            class="el-table__header"
            style="width: 100%;"
          >
            <thead class="has-gutter">
              <tr class>
                <th class="is-center">
                  <div class="cell">联系人</div>
                </th>
                <th class="is-center">
                  <div class="cell">联系人电话</div>
                </th>
                <th class="is-center">
                  <div class="cell">预约时间</div>
                </th>
                <th class="is-center">
                  <div class="cell">自提点</div>
                </th>
              </tr>
            </thead>
            <td class="is-center">
              {{ fetch.contact }}
            </td>
            <td class="is-center">
              {{ fetch.phone }}
            </td>
            <td class="is-center">
              {{ fetch.begin_time }} 至 {{ fetch.end_time }}
            </td>
            <td class="is-center" style="line-height: 30px">
              <div style="font-weight: bold;">{{ fetch.address_name }}</div>
              <div>{{ fetch.address && fetch.address.address }}</div>
            </td>
          </table>
        </div>
      </div>
    </section>

    <!--  -->
    <section v-if="detail.invoice_status == 20">
      <el-divider content-position="left">发票信息</el-divider>
      <div
        class="el-table el-table--border"
        style="width: 100%;"
      >
        <div class="el-table__header-wrapper">
          <table
            cellspacing="0"
            cellpadding="0"
            border="0"
            class="el-table__header"
            style="width: 100%;"
          >
            <thead class="has-gutter">
              <tr class>
                <th class="is-center">
                  <div class="cell">发票类型</div>
                </th>
                <th class="is-center">
                  <div class="cell">发票抬头</div>
                </th>
                <th v-if="invoice.category == 20" class="is-center">
                  <div class="cell">纳税人识别号</div>
                </th>
                <th v-if="invoice.category == 20" class="is-center">
                  <div class="cell">开户行</div>
                </th>
                <th v-if="invoice.category == 20" class="is-center">
                  <div class="cell">银行账号</div>
                </th>
                <th class="is-center">
                  <div class="cell">手机号</div>
                </th>
                <th class="is-center">
                  <div class="cell">邮箱</div>
                </th>
              </tr>
            </thead>
            <td class="is-center">
              <section v-if="invoice.category == 10">个人</section>
              <section v-if="invoice.category == 20">单位</section>
            </td>
            <td class="is-center">
              {{ invoice.title }}
            </td>
            <td v-if="invoice.category == 20" class="is-center">
              {{ invoice.tax_no }}
            </td>
            <td v-if="invoice.category == 20" class="is-center">
              {{ invoice.bank_name }}
            </td>
            <td v-if="invoice.category == 20" class="is-center">
              {{ invoice.bank_account }}
            </td>
            <td class="is-center">
              {{ invoice.phone }}
            </td>
            <td class="is-center">
              {{ invoice.email }}
            </td>
          </table>
        </div>
      </div>
    </section>
    <div style="min-height: 20px;">
      <!--  -->
    </div>
    <!-- 操作区 -->
    <footer>
      <!-- <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button> -->
      <el-button @click="$router.go(-1)">返 回</el-button>
    </footer>
  </div>
</template>

<script>
import { detail } from '@/api/order'

export default {
  name: 'OrderDetail',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      active: 0,
      detail: {},
      goods: [],
      logistics: {},
      fetch: {},
      invoice: {}
    }
  },
  computed: {},
  created () {
    this.loading = true
    detail(this.$route.params.id)
      .then(res => {
        this.detail = res.data
        this.active = this.detail.order_status.value
        this.goods = res.data.goods
        this.logistics = res.data.logistics
        this.fetch = res.data.fetch
        this.invoice = res.data.invoice
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {}
}
</script>

<style scoped>
/*  */
</style>

