<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item label="独立分销" prop="distribution_status">
        <el-radio-group v-model="form.distribution_status">
          <el-radio-button :label="10">关闭</el-radio-button>
          <el-radio-button :label="20">开启</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <section v-show="form.distribution_status == 20">
        <el-form-item label="分销佣金类型" prop="distribution_type">
          <el-radio-group v-model="form.distribution_type">
            <el-radio :label="10">百分比</el-radio>
            <el-radio :label="20">固定金额</el-radio>
          </el-radio-group>
        </el-form-item>
      </section>
      <el-form-item prop="sku" label="商品规格">
        <div style="overflow-x: auto;">
          <table class="stock-table" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th v-for="(item, index) in header" :key="index" style="min-width: 100px;">{{ item }}</th>
                <th v-if="detail.sku_type == 20" style="min-width: 200px;">规格名</th>
                <th style="min-width: 100px;">销售价</th>
                <th style="min-width: 100px;">成本价</th>
                <th style="min-width: 100px;">重量(Kg)</th>
                <th style="min-width: 100px;">库存</th>
                <th style="min-width: 100px;">积分</th>
                <th v-show="form.distribution_status == 20" style="min-width: 100px;">一级佣金({{ form.distribution_type == 10 ? '%' : '元' }})</th>
                <th v-show="form.distribution_status == 20" style="min-width: 100px;">二级佣金({{ form.distribution_type == 10 ? '%' : '元' }})</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.sku" :key="index">
                <td
                  v-for="(subItem, subIndex) in item.value"
                  :key="subIndex"
                >{{ subItem.spec_value.name }}</td>
                <td v-if="detail.sku_type == 20"><el-input v-model="form.sku[index].sku_name" size="mini" /></td>
                <td><el-input-number v-model="form.sku[index].sales_price" :precision="2" :min="0" size="mini" /></td>
                <td><el-input-number v-model="form.sku[index].cost_price" :precision="2" :min="0" size="mini" /></td>
                <td><el-input-number v-model="form.sku[index].weight" :precision="2" :min="0" size="mini" /></td>
                <td><el-input-number v-model="form.sku[index].stock" :precision="2" :min="0" size="mini" /></td>
                <td><el-input-number v-model="form.sku[index].points" :min="0" size="mini" /></td>
                <td v-show="form.distribution_status == 20"><el-input-number v-model="form.sku[index].level_one" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" size="mini" /></td>
                <td v-show="form.distribution_status == 20"><el-input-number v-model="form.sku[index].level_two" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" size="mini" /></td>
              </tr>
              <tr>
                <td colspan="20" class="wh-foot" style="text-align: left;">
                  <span class="label">批量设置：</span>
                  <ul v-if="!batchSetting" class="set-list" style="margin-left: -50px;">
                    <li class="set-item" @click="batchSettingInput('sales_price')">销售价</li>
                    <li class="set-item" @click="batchSettingInput('cost_price')">成本价</li>
                    <li class="set-item" @click="batchSettingInput('weight')">重量</li>
                    <li class="set-item" @click="batchSettingInput('stock')">库存</li>
                    <li class="set-item" @click="batchSettingInput('points')">积分</li>
                    <li v-show="form.distribution_status == 20" class="set-item" @click="batchSettingInput('level_one')">一级佣金</li>
                    <li v-show="form.distribution_status == 20" class="set-item" @click="batchSettingInput('level_two')">二级佣金</li>
                  </ul>
                  <div v-else class="set-form">
                    <el-input
                      v-model="batchSettingValue"
                      size="mini"
                      placeholder="输入要设置的数量"
                      @keyup.enter.native="onBatchSetting"
                    />
                    <i class="set-btn blue el-icon-check" @click="onBatchSetting" />
                    <i class="set-btn red el-icon-close" @click="onBatchSettingCancel" />
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </el-form-item>
      <el-form-item label="划线价" prop="line_price">
        <el-input-number v-model="form.line_price" :precision="2" :min="0" style="width: 200px" />
      </el-form-item>
      <el-form-item label="起售数量" prop="min_quantity">
        <el-input-number v-model="form.min_quantity" :min="1" :max="65535" style="width: 200px" />
        <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
          商品数量达到该值方可购买
        </el-alert>
      </el-form-item>
      <el-form-item label="限购数量" prop="quota_quantity">
        <el-input-number v-model="form.quota_quantity" :min="0" :max="65535" style="width: 200px" />
        <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
          用户单次最大可购买的商品数量，0为不限制购买数量（除不限购情况之外，限购数量应大于起售数量）
        </el-alert>
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { sale, doSale } from '@/api/goods'

export default {
  name: 'GoodsEditSale',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    const skuCheck = (rule, value, callback) => {
      if (value.length === 0) {
        callback(new Error('输入规格值'))
      } else {
        this.form.sku.forEach(item => {
          if (item.sales_price === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
          if (item.cost_price === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
          if (item.stock === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
          if (item.points === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
          if (this.detail.distribution_status === 20 && item.level_one === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
          if (this.detail.distribution_status === 20 && item.level_two === undefined) {
            callback(new Error('输入规格值'))
            return false
          }
        })
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      /* 多规格参数 */
      batchSetting: false, // 是否打开批量设置输入框
      batchSettingValue: '', // 批量设置的值
      batchSettingType: '', // 设置的字段
      header: [],
      detail: {},
      form: {
        id: null,
        distribution_status: 10,
        distribution_type: 10,
        sku: [],
        line_price: 0,
        min_quantity: 1,
        limit_quantity: 0
      },
      rules: {
        distribution_status: [{ required: true, message: '独立分销', trigger: 'change' }],
        distribution_type: [{ required: true, message: '分销类型', trigger: 'change' }],
        sku: [{ required: true, trigger: 'blur', validator: skuCheck }],
        line_price: [{ required: true, message: '请输入划线价', trigger: 'blur' }],
        min_quantity: [{ required: true, message: '请输入起售数量', trigger: 'blur' }],
        quota_quantity: [{ required: true, message: '请输入限购数量', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    sale(this.id)
      .then(res => {
        const { detail, header, sku } = res.data
        this.detail = detail
        this.header = header
        this.form.id = detail.id
        this.form.distribution_status = detail.distribution_status
        this.form.distribution_type = detail.distribution_type
        this.form.sku = sku
        this.form.line_price = detail.line_price
        this.form.min_quantity = detail.min_quantity
        this.form.quota_quantity = detail.quota_quantity
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      console.log(this.form)
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          doSale(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    /**
     * 处理选择属性事件
     */
    specChange (event) {
      const header = []
      const column = []
      const spec = []
      const sku = []
      event.forEach(value => {
        if (header.indexOf(value[0]) < 0) {
          header.push(value[0])
          spec[value[0]] = []
        }
        spec[value[0]].push(value[1])
      })
      spec.forEach(item => {
        column.push(item)
      })
      column.reverse()
      this.column = this.combine(column)
      this.header = header
      this.column.forEach((item, index) => {
        const sku_name = []
        item.forEach(subItem => {
          sku_name.push(this.getColumn(subItem))
        })
        sku[index] = {
          sales_price: 0,
          cost_price: 0,
          stock: 0,
          weight: 0,
          sku_name: sku_name.join(','),
          sku_no: item.join(':')
        }
      })
      this.form.sku = sku
    },

    /**
     * 计算笛卡尔积
     */
    combine (array) {
      const result = [];
      (function f (t, a, n) {
        if (n === 0) return result.push(t)
        for (let i = 0; i < a[n - 1].length; i++) {
          f(t.concat(a[n - 1][i]), a, n - 1)
        }
      })([], array, array.length)
      return result
    },

    /**
     * 根据属性ID获取属性名称
     */
    getHeader (id) {
      const hash = []
      this.spec.forEach(item => {
        hash[item.id] = item.name
      })
      return hash[id]
    },

    /**
     * 根据属性值ID获取属性值名称
     */
    getColumn (id) {
      const hash = []
      this.spec.forEach(item => {
        item.value.forEach(subItem => {
          hash[subItem.id] = subItem.name
        })
      })
      return hash[id]
    },

    // 打开设置框
    batchSettingInput (type) {
      this.batchSettingType = type
      this.batchSetting = true
    },

    // 取消批量设置
    onBatchSettingCancel () {
      this.batchSettingValue = ''
      this.batchSettingType = ''
      this.batchSetting = false
    },

    // 批量设置
    onBatchSetting () {
      this.form.sku.forEach(item => {
        item[this.batchSettingType] = this.batchSettingValue
      })
      this.onBatchSettingCancel()
    }
  }
}
</script>

<style scoped>
.stock-table {
  width: 100%;
  padding: 0;
  border-collapse: separate;
  border-color: #dfe6ec;
  border-style: solid;
  border-width: 1px 0 0 1px;
  background-color: #fff;
}
.stock-table td,
.stock-table th {
  padding: 4px 10px;
  border-bottom: 1px solid #dfe6ec;
  border-right: 1px solid #dfe6ec;
  text-align: center;
}
.stock-table th {
  line-height: 30px;
  background-color: #eef1f6;
}
.stock-table .link {
  cursor: pointer;
  color: #0088ee;
  font-size: 13px;
  margin-left: 6px;
}
.stock-table .wh-foot {
  line-height: 30px;
}
.stock-table .wh-foot .label {
  display: inline-block;
  vertical-align: top;
}
.stock-table .wh-foot .set-list {
  display: inline-block;
  vertical-align: top;
  font-size: 0;
}
.stock-table .wh-foot .set-list .set-item {
  display: inline-block;
  vertical-align: top;
  margin-left: 15px;
  font-size: 13px;
  cursor: pointer;
  color: #0088ee;
}
.stock-table .wh-foot .set-form {
  display: inline-block;
  margin-left: 10px;
}
.stock-table .wh-foot .set-form .el-input {
  display: inline-block;
  width: 120px;
}
.stock-table .wh-foot .set-form .set-btn {
  display: inline-block;
  padding: 0 2px;
  font-size: 15px;
  cursor: pointer;
}
.stock-table .wh-foot .set-form .set-btn.blue {
  color: #0088ee;
}
.stock-table .wh-foot .set-form .set-btn.red {
  color: #cc0000;
}
.stock-table .wh-foot .right {
  float: right;
}
.stock-table .wh-foot .text {
  font-size: 13px;
}
</style>

