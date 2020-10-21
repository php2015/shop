<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-tabs type="border-card">
        <!-- 基本 -->
        <el-tab-pane label="基础设置">
          <el-form-item label="短信功能" prop="status">
            <el-radio-group v-model="form.status">
              <el-radio-button border label="10">关闭</el-radio-button>
              <el-radio-button border label="20">开启</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <section v-if="form.status == 20">
            <el-form-item label="短信平台" prop="driver">
              <el-radio-group v-model="form.driver">
                <el-radio-button label="ali">阿里云</el-radio-button>
                <!-- <el-radio-button label="tencent">腾讯云</el-radio-button> -->
              </el-radio-group>
            </el-form-item>
            <el-form-item label="AppID" prop="app_id">
              <el-input v-model.trim="form.app_id" clearable placeholder="AppID" style="width:40%" />
            </el-form-item>
            <el-form-item label="AppSecret" prop="app_secret">
              <el-input
                v-model.trim="form.app_secret"
                clearable
                placeholder="AppSecret"
                style="width:40%"
              />
            </el-form-item>
            <el-form-item label="签名" prop="sign">
              <el-input v-model.trim="form.sign" clearable placeholder="签名" style="width:40%" />
            </el-form-item>
          </section>
        </el-tab-pane>
        <!-- 模板 -->
        <el-tab-pane label="模板设置">
          <el-form-item prop="template" label-width="0">
            <el-table
              :data="form.template"
              style="width: 100%"
            >
              <el-table-column
                prop="name"
                label="名称"
                width="200"
                align="center"
              />
              <el-table-column label="模板" align="center">
                <template slot-scope="scope">
                  <el-input v-model.trim="scope.row.value" clearable placeholder="模板" />
                </template>
              </el-table-column>
              <!-- <el-table-column prop="status" label="状态" align="center">
                <template slot-scope="scope">
                  <el-switch
                    v-model="scope.row.status"
                    active-color="#13ce66"
                    :inactive-value="10"
                    :active-value="20"
                  />
                </template>
              </el-table-column> -->
            </el-table>
          </el-form-item>
        </el-tab-pane>
      </el-tabs>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingMessageSms',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        driver: 'ali',
        app_id: '',
        app_secret: '',
        sign: '',
        status: 10,
        template: [
          {
            name: '新订单通知',
            key: 'NEW_ORDER',
            value: '',
            status: 10
          }
        ]
      },
      rules: {
        status: [{ required: true, message: '', trigger: 'blur' }],
        driver: [{ required: true, message: '', trigger: 'blur' }],
        app_id: [{ required: true, message: '请输入AppID', trigger: 'blur' }],
        app_secret: [{ required: true, message: '请输入AppSecret', trigger: 'blur' }],
        sign: [{ required: true, message: '请输入签名', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    get('message.sms').then(res => {
      if (res.data) {
        this.form = res.data
      }
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          save('message.sms', this.form).then(res => {
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

