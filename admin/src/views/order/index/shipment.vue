<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="快递公司" prop="express_id">
        <el-select v-model="form.express_id" clearable placeholder="请选择" style="width:80%">
          <el-option
            v-for="(item, index) in express"
            :key="index"
            :label="item.company"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="快递单号" prop="express_no">
        <el-input v-model.trim="form.express_no" clearable placeholder="物流单号" style="width:80%" />
      </el-form-item>
      <el-form-item label="联系人" prop="contact">
        <el-input v-model.trim="form.contact" clearable placeholder="联系人" style="width:80%" />
      </el-form-item>
      <el-form-item label="联系电话" prop="phone">
        <el-input v-model.trim="form.phone" clearable placeholder="联系电话" style="width:80%" />
      </el-form-item>
      <el-form-item label="省份" prop="province">
        <el-input v-model.trim="form.province" clearable placeholder="省份" style="width:80%" />
      </el-form-item>
      <el-form-item label="城市" prop="city">
        <el-input v-model.trim="form.city" clearable placeholder="城市" style="width:80%" />
      </el-form-item>
      <el-form-item label="区/县" prop="district">
        <el-input v-model.trim="form.district" clearable placeholder="区/县" style="width:80%" />
      </el-form-item>
      <el-form-item label="详细地址" prop="detail">
        <el-input
          v-model="form.detail"
          type="textarea"
          :autosize="{ minRows: 2, maxRows: 4}"
          placeholder="详细地址"
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
import { shipment, doShipment } from '@/api/order'

export default {
  name: 'OrderShipment',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      express: [],
      form: {},
      rules: {
        express_id: [{ required: true, message: '请选择快递公司', trigger: 'change' }],
        contact: [{ required: true, message: '请输入联系人', trigger: 'blur' }],
        phone: [{ required: true, message: '请输入联系电话', trigger: 'blur' }],
        province: [{ required: true, message: '请输入省份', trigger: 'blur' }],
        city: [{ required: true, message: '请输入城市', trigger: 'blur' }],
        district: [{ required: true, message: '请输入区/县', trigger: 'blur' }],
        detail: [{ required: true, message: '请输入详细地址', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    shipment(this.$route.params.id)
      .then(res => {
        const { data } = res
        const { express, detail } = data
        this.express = express
        this.form = detail.logistics
        this.form.express_id = this.form.express_id === 0 ? null : this.form.express_id
        console.log(this.form)
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
          doShipment(this.form).then(res => {
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

