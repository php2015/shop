<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="" prop="driver">
        <el-radio-group v-model="form.driver" @change="test">
          <el-radio-button label="local">本地存储(不推荐)</el-radio-button>
          <el-radio-button label="ali">阿里云</el-radio-button>
          <el-radio-button label="tencent">腾讯云</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <section v-if="form.driver == 'ali'">
        <el-form-item label="AppID" prop="app_id">
          <el-input v-model.trim="form.app_id" clearable placeholder="AppID" style="width:60%" />
        </el-form-item>
        <el-form-item label="AppSecret" prop="app_secret">
          <el-input v-model.trim="form.app_secret" clearable placeholder="AppSecret" style="width:60%" />
        </el-form-item>
        <el-form-item label="Bucket（存储空间）" prop="bucket">
          <el-input v-model.trim="form.bucket" clearable placeholder="存储空间" style="width:60%" />
        </el-form-item>
        <el-form-item label="Endpoint（地域节点）" prop="endpoint">
          <el-input v-model.trim="form.endpoint" clearable placeholder="地域节点" style="width:60%">
            <template slot="prepend">Https://</template>
          </el-input>
        </el-form-item>
        <!-- <el-form-item label="地域节点 Endpoint" prop="endpoint">
          <el-input v-model.trim="form.endpoint" placeholder="地域节点 Endpoint" style="width:60%">
            <template slot="prepend">Http://</template>
          </el-input>
        </el-form-item> -->
      </section>
      <section v-if="form.driver == 'tencent'">
        <el-form-item label="SecretId" prop="secret_id">
          <el-input v-model.trim="form.secret_id" clearable placeholder="SecretId" style="width:60%" />
        </el-form-item>
        <el-form-item label="SecretKey" prop="secret_key">
          <el-input v-model.trim="form.secret_key" clearable placeholder="SecretKey" style="width:60%" />
        </el-form-item>
        <el-form-item label="Bucket（存储空间）" prop="tencent_bucket">
          <el-input v-model.trim="form.tencent_bucket" clearable placeholder="存储空间" style="width:60%" />
        </el-form-item>
        <el-form-item label="Region（地域节点）" prop="region">
          <el-input v-model.trim="form.region" clearable placeholder="地域节点" style="width:60%">
            <template slot="prepend">Https://</template>
          </el-input>
        </el-form-item>
      </section>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingSystemStorage',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        driver: 'local',
        app_id: '',
        app_secret: '',
        bucket: '',
        endpoint: '',
        tencent_bucket: '',
        secret_id: '',
        secret_key: '',
        region: ''
      },
      rules: {
        driver: [{ required: true, message: '', trigger: 'blur' }],
        app_id: [{ required: true, message: '请输入AppID', trigger: 'blur' }],
        app_secret: [{ required: true, message: '请输入AppSecret', trigger: 'blur' }],
        bucket: [{ required: true, message: '请输入存储空间', trigger: 'blur' }],
        endpoint: [{ required: true, message: '请输入地域节点', trigger: 'blur' }],
        tencent_bucket: [{ required: true, message: '请输入存储空间', trigger: 'blur' }],
        secret_id: [{ required: true, message: '请输入SecretId', trigger: 'blur' }],
        secret_key: [{ required: true, message: '请输入SecretKey', trigger: 'blur' }],
        region: [{ required: true, message: '请输入地域节点', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('storage.base').then(res => {
        if (res.data) {
          this.form = res.data
        }
      })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          save('storage.base', this.form).then(res => {
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

    test () {
      this.$refs['form'].clearValidate()
    }
  }
}
</script>

<style>
/*  */
</style>

