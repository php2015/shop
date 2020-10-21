<template>
  <div class="app-container">
    <el-page-header content="添加商品" @back="$router.push('/goods')" />
    <el-divider />
    <div class="el-steps el-steps--simple">
      <div class="el-step is-simple" style="flex-basis: 25%; cursor: pointer;">
        <div class="el-step__main" @click="stepClick('step1')">
          <div class="el-step__title is-process">基础信息</div>
          <div class="el-step__arrow" />
        </div>
      </div>
      <div class="el-step is-simple" style="flex-basis: 25%; cursor: pointer;">
        <div class="el-step__main" @click="stepClick('step2')">
          <div class="el-step__title is-process">图文描述</div>
          <div class="el-step__arrow" />
        </div>
      </div>
      <div class="el-step is-simple" style="flex-basis: 25%; cursor: pointer;">
        <div class="el-step__main" @click="stepClick('step3')">
          <div class="el-step__title is-process">销售信息</div>
          <div class="el-step__arrow" />
        </div>
      </div>
      <div class="el-step is-simple" style="flex-basis: 25%; cursor: pointer;">
        <div class="el-step__main" @click="stepClick('step4')">
          <div class="el-step__title is-process">物流信息</div>
          <div class="el-step__arrow" />
        </div>
      </div>
      <div class="el-step is-simple is-flex" style="flex-basis: 25%; cursor: pointer;">
        <div class="el-step__main" @click="stepClick('step5')">
          <div class="el-step__title is-process">其他信息</div>
          <div class="el-step__arrow" />
        </div>
      </div>
    </div>

    <el-form
      ref="form"
      v-loading="loading"
      :model="form"
      :rules="rules"
      label-width="20%"
    >
      <!-- 基本信息 -->
      <section ref="step1">
        <el-divider content-position="left">基本信息</el-divider>
        <el-form-item label="商品分类" prop="category_id">
          <tree-select
            v-model="form.category_id"
            :options="category"
            :normalizer="normalizer"
            :default-expand-level="0"
            placeholder="请选择"
            style="width:80%"
            @input="categorySelected"
          />
        </el-form-item>
        <el-form-item label="商品名称" prop="goods_name">
          <el-input v-model.trim="form.goods_name" placeholder="商品名称" style="width:80%" />
        </el-form-item>
        <el-form-item label="单位" prop="unit">
          <el-select v-model="form.unit" placeholder="单位" style="width:80%">
            <el-option v-for="item in unit" :key="item.id" :label="item.unit" :value="item.unit" />
          </el-select>
        </el-form-item>
        <el-form-item label="商品卖点" prop="subtitle">
          <el-input v-model.trim="form.subtitle" placeholder="商品卖点" style="width:80%" />
          <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
            在商品详情页标题下面展示卖点信息，建议60字以内
          </el-alert>
        </el-form-item>
        <el-form-item label="商品分组" prop="group">
          <el-select v-model="form.group" multiple placeholder="请选择" style="width:80%">
            <el-option
              v-for="item in group"
              :key="item.id"
              :label="item.group_name"
              :value="item.id"
              :disabled="item.status == 10"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="商品支持" prop="support">
          <el-select v-model="form.support" multiple placeholder="商品支持" style="width:80%">
            <el-option
              v-for="item in support"
              :key="item.id"
              :label="item.support_name"
              :value="item.id"
            />
          </el-select>
        </el-form-item>
      </section>
      <!-- 图文描述 -->
      <section ref="step2">
        <el-divider content-position="left">图文描述</el-divider>
        <el-form-item label="商品白底图" prop="image">
          <el-alert type="info" :closable="false" style="margin-bottom: 5px; line-height: 1.15; width: 80%">
            <strong>商品列表页面使用，</strong>文件格式JPEG/PNG/GIF，图片大小不能超过5MB，图片尺寸建议300*300
          </el-alert>
          <upload-single
            :action="imageAction"
            :width="100"
            :height="100"
            @onSuccess="handleImageSuccess"
          />
        </el-form-item>
        <el-form-item label="商品主图" prop="image_list">
          <el-alert type="info" :closable="false" style="margin-bottom: 5px; line-height: 1.15; width: 80%">
            <strong>商品详情页使用，</strong>文件格式 JPEG/PNG/GIF，图片大小不能超过5MB，图片尺寸建议800*800以上
          </el-alert>
          <upload-images
            :action="imageListAction"
            :file-list="image_list"
            @onSuccess="handleBannerSuccess"
            @onRemove="handleBannerRemove"
          />
        </el-form-item>
        <el-form-item label="商品详情" prop="content">
          <tinymce v-model="content" :height="300" />
        </el-form-item>
      </section>
      <!-- 销售信息 -->
      <section ref="step3">
        <el-divider content-position="left">销售信息</el-divider>
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
        <el-form-item label="规格类型" prop="sku_type">
          <el-radio-group v-model="form.sku_type">
            <el-radio-button :label="10">单规格</el-radio-button>
            <el-radio-button :label="20">多规格</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <!-- 单规格 -->
        <section v-if="form.sku_type == 10">
          <el-form-item prop="sku" label="商品规格">
            <div style="padding-top: 5px; overflow-x: auto;">
              <table class="stock-table" cellspacing="0" cellpadding="0" style="width: 100%;">
                <thead>
                  <tr>
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
                  <tr>
                    <td><el-input-number v-model="form.sku[0].sales_price" :precision="2" :min="0" size="mini" /></td>
                    <td><el-input-number v-model="form.sku[0].cost_price" :precision="2" :min="0" size="mini" /></td>
                    <td><el-input-number v-model="form.sku[0].weight" :precision="2" :min="0" size="mini" /></td>
                    <td><el-input-number v-model="form.sku[0].stock" :precision="2" :min="0" size="mini" /></td>
                    <td><el-input-number v-model="form.sku[0].points" :min="0" size="mini" /></td>
                    <td v-show="form.distribution_status == 20"><el-input-number v-model="form.sku[0].level_one" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" size="mini" /></td>
                    <td v-show="form.distribution_status == 20"><el-input-number v-model="form.sku[0].level_two" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" size="mini" /></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </el-form-item>
        </section>
        <!-- 多规格 -->
        <section v-if="form.sku_type == 20">
          <el-form-item prop="sku" label="商品规格">
            <el-cascader
              :options="spec"
              :props="{
                multiple: true,
                label: 'name',
                value: 'id',
                children: 'value'
              }"
              clearable
              style="width:100%"
              @change="specChange"
            />
            <div v-if="header.length > 0" style="padding-top: 5px; overflow-x: auto;">
              <table class="stock-table" cellspacing="0" cellpadding="0" style="width: 100%;">
                <thead>
                  <tr>
                    <th v-for="(item, index) in header" :key="index" style="min-width: 100px;">{{ getHeader(item) }}</th>
                    <th style="min-width: 200px;">规格名</th>
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
                  <tr v-for="(item, index) in column" :key="index">
                    <td v-for="(subItem, subIndex) in item" :key="subIndex">{{ getColumn(subItem) }}</td>
                    <td><el-input v-model="form.sku[index].sku_name" size="mini" /></td>
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
        </section>
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
      </section>
      <!-- 物流信息 -->
      <section ref="step4">
        <el-divider content-position="left">物流信息</el-divider>
        <!-- 快递发货 -->
        <el-form-item v-if="method.indexOf(10) >= 0" label="快递发货">
          <el-switch v-model="form.is_express" :inactive-value="10" :active-value="20" />
        </el-form-item>
        <el-form-item v-if="form.is_express == 20" label="快递运费模板" prop="express_template_id">
          <el-select v-model="form.express_template_id" placeholder="选择模板" style="width: 200px">
            <el-option
              v-for="item in express"
              :key="item.id"
              :value="item.id"
              :label="item.name + ' ('+(item.method == 10 ? '按件数' : '按重量')+')'"
            />
          </el-select>
        </el-form-item>
        <!-- 同城配送 -->
        <el-form-item v-if="method.indexOf(20) >= 0" label="同城配送">
          <el-switch v-model="form.is_local" :inactive-value="10" :active-value="20" />
        </el-form-item>
        <el-form-item v-if="form.is_local == 20" label="同城运费模板" prop="local_template_id">
          <el-select v-model="form.local_template_id" placeholder="选择模板" style="width: 200px">
            <el-option
              v-for="item in local"
              :key="item.id"
              :value="item.id"
              :label="item.name + ' ('+(item.method == 10 ? '按距离' : '按重量')+')'"
            />
          </el-select>
        </el-form-item>
        <!-- 上门自提 -->
        <el-form-item v-if="method.indexOf(30) >= 0" label="上门自提">
          <el-switch v-model="form.is_fetch" :inactive-value="10" :active-value="20" />
        </el-form-item>
      </section>
      <!-- 其他信息 -->
      <section ref="step5">
        <el-divider content-position="left">其他信息</el-divider>
        <el-form-item label="初始销量" prop="sales_init">
          <el-input-number v-model="form.sales_init" :min="0" label="初始销量" style="width: 200px;" />
          <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
            虚拟销量，不计入后台实际销量
          </el-alert>
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
            数值越小越靠前
          </el-alert>
        </el-form-item>
        <el-form-item label="状态" prop="status">
          <el-radio-group v-model="form.status">
            <el-radio-button :label="20">上架销售</el-radio-button>
            <el-radio-button :label="10">放入仓库</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item v-if="form.status == 20" label="上架时间" prop="sales_time">
          <el-date-picker
            v-model="form.sales_time"
            type="datetime"
            placeholder="选择日期时间"
            value-format="yyyy-MM-dd HH:mm:ss"
            :picker-options="pickerOptions"
          />
          <el-alert type="info" :closable="false" style="margin-top: 5px; line-height: 1.15; width: 80%">
            不选择时间为立即上架
          </el-alert>
        </el-form-item>
      </section>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/goods'
import UploadSingle from '@/components/Upload/Single'
import UploadImages from '@/components/Upload/Images'
import Tinymce from '@/components/Tinymce'
import treeSelect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  name: 'GoodsAdd',
  components: {
    treeSelect,
    UploadSingle,
    UploadImages,
    Tinymce
  },
  data () {
    const image = (rule, value, callback) => {
      if (!value) {
        callback(new Error('请上传商品主图'))
      } else {
        callback()
      }
    }
    const imageList = (rule, value, callback) => {
      if (value.length === 0) {
        callback(new Error('请至少上传一张商品图片'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      active: 0,
      imageAction: process.env.VUE_APP_BASE_API + '/upload/goods.image/300/300',
      imageListAction: process.env.VUE_APP_BASE_API + '/upload/goods.banner',
      image_list: [],
      category: [], // 分类列表
      group: [], // 分组列表
      support: [], // 支持列表
      unit: [], // 单位列表
      express: [], // 快递运费模板
      local: [], // 同城运费模板
      method: [], // 支持的配送方式
      /* 多规格参数 */
      header: [], // table header
      column: [], // table row
      spec: [], // 规格列表生成select
      batchSetting: false, // 是否打开批量设置输入框
      batchSettingValue: '', // 批量设置的值
      batchSettingType: '', // 设置的字段
      content: '',
      form: {
        category_id: null,
        group: null,
        support: null,
        express_template_id: null,
        local_template_id: null,
        image: '',
        image_list: [],
        goods_name: '',
        unit: '',
        subtitle: '',
        distribution_status: 10,
        distribution_type: 10,
        level_one: 0,
        level_two: 0,
        sku_type: 10,
        sku: [],
        line_price: 0,
        min_quantity: 1,
        quota_quantity: 0,
        sales_init: 0,
        is_express: 10,
        is_local: 10,
        is_fetch: 10,
        sort: 0,
        status: 10,
        content: ''
      },
      pickerOptions: {
        shortcuts: [{
          text: '明天',
          onClick (picker) {
            const date = new Date()
            date.setTime(new Date(new Date().toLocaleDateString()).getTime() + 3600 * 1000 * 24)
            picker.$emit('pick', date)
          }
        }, {
          text: '一周后',
          onClick (picker) {
            const date = new Date()
            date.setTime(new Date(new Date().toLocaleDateString()).getTime() + 3600 * 1000 * 24 * 7)
            picker.$emit('pick', date)
          }
        }]
      },
      rules: {
        category_id: [{ required: true, message: '请选择分类', trigger: 'change' }],
        goods_name: [{ required: true, message: '请输入商品名称', trigger: 'blur' }],
        image: [{ required: true, trigger: 'change', validator: image }],
        image_list: [{ required: true, trigger: 'change', validator: imageList }],
        unit: [{ required: true, message: '请选择商品单位', trigger: 'change' }],
        distribution_status: [{ required: true, message: '独立分销', trigger: 'change' }],
        distribution_type: [{ required: true, message: '分销类型', trigger: 'change' }],
        sku_type: [{ required: true, message: '规格类型', trigger: 'change' }],
        sku: [{ required: true, message: '商品规格', trigger: 'change' }],
        line_price: [{ required: true, message: '请输入划线价', trigger: 'blur' }],
        min_quantity: [{ required: true, message: '请输入起售数量', trigger: 'blur' }],
        quota_quantity: [{ required: true, message: '请输入限购数量', trigger: 'blur' }],
        express_template_id: [{ required: true, message: '请选择快递运费模板', trigger: 'change' }],
        local_template_id: [{ required: true, message: '请选择同城运费模板', trigger: 'change' }],
        sales_init: [{ required: true, message: '请输入初始销量', trigger: 'blur' }],
        sort: [{ required: true, message: '请输入排序值', trigger: 'blur' }],
        status: [{ required: true, message: '状态', trigger: 'blur' }]
      }
    }
  },
  computed: {},
  watch: {
    content () {
      this.form.content = encodeURIComponent(this.content)
    },
    'form.sku_type': {
      handler (value) {
        if (value === 10) {
          this.form.sku[0] = {
            sales_price: 0,
            cost_price: 0,
            stock: 0,
            weight: 0,
            points: 0,
            level_one: 0,
            level_two: 0,
            sku_name: '',
            sku_no: ''
          }
        } else {
          this.form.sku = []
        }
      },
      immediate: true
    }
  },
  created () {
    this.loading = true
    add().then(res => {
      const { data } = res
      this.form.sort = data.sort
      this.category = data.category
      this.group = data.group
      this.support = data.support
      this.unit = data.unit
      this.spec = data.spec
      this.express = data.express
      this.local = data.local
      this.method = data.method
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    normalizer (node) {
      if (node.children && !node.children.length) {
        delete node.children
      }
      return {
        id: node.id,
        label: node.category_name,
        children: node.children,
        isDisabled: node.status === 10
      }
    },

    categorySelected (id) {
      this.form.category_id = id
      this.$refs.form.validateField('category_id')
    },

    stepClick (step) {
      window.scrollTo({
        top: this.$refs[step].offsetTop - 100,
        behavior: 'smooth'
      })
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          if (this.form.is_express === 10 && this.form.is_local === 10 && this.form.is_fetch === 10) {
            this.$message.warning('至少选择一种物流方式')
            return false
          }
          this.form.express_template_id = this.form.express_template_id ? this.form.express_template_id : 0
          this.form.local_template_id = this.form.local_template_id ? this.form.local_template_id : 0
          this.submitLoading = true
          doAdd(this.form).then(res => {
            this.$message({
              message: res.msg,
              type: 'success'
            })
            this.$router.go(-1)
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    handleImageSuccess (file) {
      this.form.image = file.response.data.file
      this.$refs.form.validateField('image')
    },

    handleBannerSuccess (fileList) {
      this.form.image_list = fileList
      this.$refs.form.validateField('image_list')
    },

    handleBannerRemove (fileList) {
      this.form.image_list = fileList
      this.$refs.form.validateField('image_list')
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
          points: 0,
          level_one: 0,
          level_two: 0,
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
  width: 80%;
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

