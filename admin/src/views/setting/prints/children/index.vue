<template>
  <div class="app-container" style="display: flex; ">
    <div style="width: 40%">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
        <el-form-item label="小票打印" prop="status">
          <el-radio-group v-model="form.status">
            <el-radio-button :label="10">关闭</el-radio-button>
            <el-radio-button :label="20">开启</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <section v-if="form.status == 20">
          <el-form-item label="打印机" prop="driver">
            <el-radio-group v-model="form.driver">
              <el-radio-button label="feieyun">飞蛾云打印</el-radio-button>
              <el-radio-button label="xpyun">芯烨云打印</el-radio-button>
            </el-radio-group>
            <div style="padding-top: 10px;">
              <el-alert :closable="false" type="info">
                <div slot="title" style="line-height: 30px;">
                  <div>
                    <p>系统只支持同一品牌的打印机进行打印和打印机的添加、编辑、删除操作。</p>
                    <p>请务必选择对应的打印机品牌后进行操作。</p>
                  </div>
                </div>
              </el-alert>
            </div>
          </el-form-item>
          <section v-if="form.driver == 'xpyun'">
            <el-form-item label="开发者ID" prop="xpyun_user">
              <el-input v-model.trim="form.xpyun_user" label="开发者ID" />
            </el-form-item>
            <el-form-item label="开发者密钥" prop="xpyun_secret">
              <el-input v-model.trim="form.xpyun_secret" label="开发者密钥" />
            </el-form-item>
          </section>
          <section v-if="form.driver == 'feieyun'">
            <el-form-item label="开发者ID(USER)" prop="feieyun_user">
              <el-input v-model.trim="form.feieyun_user" label="开发者ID" />
            </el-form-item>
            <el-form-item label="开发者密钥(UKEY)" prop="feieyun_secret">
              <el-input v-model.trim="form.feieyun_secret" label="开发者密钥" />
            </el-form-item>
          </section>
          <el-form-item label="页头文本" prop="header">
            <el-input v-model="header" type="textarea" :autosize="{ minRows: 6 }" label="页头文本" />
          </el-form-item>
          <el-form-item label="页尾文本" prop="footer">
            <el-input v-model="footer" type="textarea" :autosize="{ minRows: 6 }" label="页尾文本" />
          </el-form-item>
        </section>
      </el-form>
      <div class="footer">
        <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
      </div>
    </div>
    <div style="width: 60%; padding-left: 10px;">
      <!-- 打印机标签说明 -->
      <div>
        <label class="el-form-item__label">系统标签说明</label>
        <el-alert title="成功提示的文案" :closable="false" type="info">
          <div slot="title" style="line-height: 30px;">
            <div>
              <strong style="color: #c7254e;">{TIME}：</strong>下单时间
            </div>
            <div>
              <strong style="color: #c7254e;">{ORDER_NO}：</strong>订单编号
            </div>
            <div>
              <strong style="color: #c7254e;">{GOODS_PRICE}：</strong>商品价格(所有商品价格合计)
            </div>
            <div>
              <strong style="color: #c7254e;">{DISCOUNT_PRICE}：</strong>优惠金额
            </div>
            <div>
              <strong style="color: #c7254e;">{LOGISTICS_FEE}：</strong>运费 / 配送费
            </div>
            <div>
              <strong style="color: #c7254e;">{PAYMENT_PRICE}：</strong>合计(实际支付金额 = 订单价格 + 运费 - 优惠金额)
            </div>
            <div>
              <strong style="color: #c7254e;">{CONTACT}：</strong>收货联系人
            </div>
            <div>
              <strong style="color: #c7254e;">{PHONE}：</strong>联系人手机号
            </div>
            <div>
              <strong style="color: #c7254e;">{ADDRESS}：</strong>收货地址
            </div>
            <div>
              <strong style="color: #c7254e;">{REMARK}：</strong>备注
            </div>
          </div>
        </el-alert>
      </div>

      <!-- 打印机标签说明 -->
      <section v-if="form.driver == 'xpyun'">
        <div style="padding-top: 20px;">
          <label class="el-form-item__label">打印机标签说明(请注意：不同打印机标签有所区别)</label>
          <el-alert :closable="false" type="info">
            <div slot="title" style="line-height: 30px;">
              <div>
                <strong style="color: #c7254e;">&lt;BR&gt;：</strong>换行符（同一行有闭合标签(如 &lt;/C&gt;)则应放到闭合标签前面, 连续两个换行符&lt;BR&gt;&lt;BR&gt;可以表示加一空行）
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;L&gt;&lt;/L&gt;：</strong>左对齐
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;C&gt;&lt;/C&gt;：</strong>居中对齐
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;R&gt;&lt;/R&gt;：</strong>右对齐
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;N&gt;&lt;/N&gt;：</strong>字体正常大小
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;HB&gt;&lt;/HB&gt;：</strong>字体变高一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;WB&gt;&lt;/WB&gt;：</strong>字体变宽一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;B&gt;&lt;/B&gt;：</strong>字体放大一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;CB&gt;&lt;/CB&gt;：</strong>字体放大一倍居中
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;HB2&gt;&lt;/HB2&gt;：</strong>字体变高二倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;WB2&gt;&lt;/WB2&gt;：</strong>字体变宽二倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;B2&gt;&lt;/B2&gt;：</strong>字体放大二倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;BOLD&gt;&lt;/BOLD&gt;：</strong>字体加粗
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;LOGO&gt;&lt;/LOGO&gt;：</strong>LOGO图片（标签内容是图片Base64格式字符串, 暂未开放）
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;QR&gt;&lt;/QR&gt;：</strong>二维码（标签内容是二维码值, 最大不能超过256个字符）
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;BARCODE&gt;&lt;/BARCODE&gt;：</strong>条形码（标签内容是条形码值）
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;CUT&gt;：</strong>切刀指令（主动切纸，仅限于切刀打印机使用才有效果。注意：切刀打印机的打印订单最后默认带一个切刀指令）
              </div>
            </div>
          </el-alert>
        </div>
      </section>
      <section v-if="form.driver == 'feieyun'">
        <div style="padding-top: 20px;">
          <label class="el-form-item__label">打印机标签说明(请注意：不同打印机标签有所区别)</label>
          <el-alert :closable="false" type="info">
            <div slot="title" style="line-height: 30px;">
              <div>
                <strong style="color: #c7254e;">&lt;BR&gt; ：</strong>换行符
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;CUT&gt; ：</strong>切刀指令(主动切纸,仅限切刀打印机使用才有效果)
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;LOGO&gt; ：</strong>打印LOGO指令(前提是预先在机器内置LOGO图片)
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;PLUGIN&gt; ：</strong>钱箱或者外置音响指令
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;CB&gt;&lt;/CB&gt;：</strong>居中放大
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;B&gt;&lt;/B&gt;：</strong>放大一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;C&gt;&lt;/C&gt;：</strong>居中
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;L&gt;&lt;/L&gt;：</strong>字体变高一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;W&gt;&lt;/W&gt;：</strong>字体变宽一倍
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;QR&gt;&lt;/QR&gt;：</strong>二维码（单个订单，最多只能打印一个二维码）
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;RIGHT&gt;&lt;/RIGHT&gt;：</strong>右对齐
              </div>
              <div>
                <strong style="color: #c7254e;">&lt;BOLD&gt;&lt;/BOLD&gt;：</strong>字体加粗
              </div>
            </div>
          </el-alert>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingPrintsIndex',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      header: '',
      footer: '',
      form: {
        status: 10,
        driver: 'xpyun',
        xpyun_user: '',
        xpyun_secret: '',
        feieyun_user: '',
        feieyun_secret: '',
        header: '',
        footer: ''
      },
      rules: {
        status: [{ required: true, message: '', trigger: 'change' }],
        driver: [{ required: true, message: '', trigger: 'change' }],
        xpyun_user: [{ required: true, message: '请输入开发者ID', trigger: 'blur' }],
        xpyun_secret: [{ required: true, message: '请输入开发者密钥', trigger: 'blur' }],
        feieyun_user: [{ required: true, message: '请输入开发者ID', trigger: 'blur' }],
        feieyun_secret: [{ required: true, message: '请输入开发者密钥', trigger: 'blur' }],
        header: [{ required: true, message: '请输入页头文本', trigger: 'blur' }],
        footer: [{ required: true, message: '请输入页尾文本', trigger: 'blur' }]
      }
    }
  },
  watch: {
    header (value) {
      this.form.header = encodeURIComponent(value)
    },
    footer (value) {
      this.form.footer = encodeURIComponent(value)
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('prints.base')
        .then(res => {
          if (res.data) {
            this.form.status = res.data.status
            // this.form.copies = res.data.copies
            this.form.driver = res.data.driver
            this.form.xpyun_user = res.data.xpyun_user
            this.form.xpyun_secret = res.data.xpyun_secret
            this.form.feieyun_user = res.data.feieyun_user
            this.form.feieyun_secret = res.data.feieyun_secret
            this.header = res.data.header
            this.footer = res.data.footer
          }
        })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.submitLoading = true
          save('prints.base', this.form)
            .then(res => {
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
    }
  }
}
</script>

<style>
/*  */
</style>

