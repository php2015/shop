<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="门店名称" prop="store_name">
        <el-input v-model.trim="form.store_name" clearable placeholder="门店名称" style="width:80%" />
      </el-form-item>
      <el-form-item label="负责人" prop="contact">
        <el-input v-model.trim="form.contact" clearable placeholder="联系人" style="width:80%" />
      </el-form-item>
      <el-form-item label="联系电话" prop="phone">
        <el-input v-model.trim="form.phone" clearable placeholder="联系电话" style="width:80%" />
      </el-form-item>
      <el-form-item label="时间类型" prop="business">
        <el-radio-group v-model="form.business">
          <el-radio-button :label="10">全天</el-radio-button>
          <el-radio-button :label="20">自定</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.business == 20" label="营业时间">
        <el-time-select
          v-model="form.business_begin"
          placeholder="起始时间"
          :picker-options="{
            start: '00:00',
            step: '00:30',
            end: '24:00'
          }"
        />
        <el-time-select
          v-model="form.business_end"
          placeholder="结束时间"
          :picker-options="{
            start: '00:00',
            step: '00:30',
            end: '24:00'
          }"
        />
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button :label="10">禁用</el-radio-button>
          <el-radio-button :label="20">启用</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
        <el-tooltip content="数值越小越靠前" placement="top">
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-divider content-position="left">其他配置</el-divider>
      <el-form-item label="所属城市" prop="location">
        <el-cascader
          v-model="form.location"
          :options="options"
          :props="{ value: 'label' }"
          style="width:80%"
          @change="handleChange"
        />
      </el-form-item>
      <el-form-item label="详细地址" prop="address">
        <el-input v-model="form.address" clearable placeholder="详细地址" style="width:80%" />
      </el-form-item>
      <el-form-item label="坐标" prop="coor">
        <el-input v-model="form.coor" clearable placeholder="坐标" style="width:80%" />
      </el-form-item>
      <el-form-item label="坐标拾取器" prop="subtitle">
        <iframe
          id="map"
          src="https://lbs.qq.com/tool/getpoint/getpoint.html"
          width="100%"
          height="600"
        />
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
import { add, doAdd } from '@/api/shop/store'
import { regionData } from 'element-china-area-data'

export default {
  name: 'ShopStoreAdd',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      options: regionData,
      form: {
        store_name: '',
        contact: '',
        phone: '',
        business: 10,
        business_time: '-',
        business_begin: '08:30',
        business_end: '18:30',
        location: [],
        province: '',
        city: '',
        district: '',
        address: '',
        coor: '',
        lon: 0,
        lat: 0,
        sort: 0,
        status: 10
      },
      rules: {
        store_name: [{ required: true, message: '请输入门店名称', trigger: 'blur' }],
        contact: [{ required: true, message: '请输入联系人', trigger: 'blur' }],
        phone: [{ required: true, message: '请输入联系电话', trigger: 'blur' }],
        status: [{ required: true, message: '请选择是否营业', trigger: 'change' }],
        business: [{ required: true, message: '请选择时间类型', trigger: 'change' }],
        location: [{ required: true, message: '请选择所属城市', trigger: 'change' }],
        province: [{ required: true, message: '请输入省份', trigger: 'blur' }],
        city: [{ required: true, message: '请输入城市', trigger: 'blur' }],
        district: [{ required: true, message: '请输入区/县', trigger: 'blur' }],
        address: [{ required: true, message: '请输入详细地址', trigger: 'blur' }],
        coor: [{ required: true, message: '请输入坐标', trigger: 'blur' }]
      }
    }
  },
  watch: {
    'form.coor' (value) {
      const array = value.split(',')
      this.form.lat = array[0]
      this.form.lon = array[1]
    }
  },
  created () {
    this.loading = true
    add().then(res => {
      this.form.sort = res.data.sort
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleChange (event) {
      this.form.location = event
      this.form.province = event[0]
      this.form.city = event[1]
      this.form.district = event[2]
      this.$refs.form.validateField('location')
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>

