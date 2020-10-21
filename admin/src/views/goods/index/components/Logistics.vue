<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <!-- 快递 -->
      <el-form-item v-if="method.indexOf(10) >= 0" label="快递发货">
        <el-switch v-model="form.is_express" :inactive-value="10" :active-value="20" />
      </el-form-item>
      <el-form-item v-if="form.is_express == 20" label="快递运费模板" prop="express_template_id">
        <el-select
          v-model="form.express_template_id"
          placeholder="选择模板"
          style="width: 200px"
        >
          <el-option
            v-for="item in express"
            :key="item.id"
            :value="item.id"
            :label="item.name + ' ('+(item.method == 10 ? '按件数' : '按重量')+')'"
          />
        </el-select>
      </el-form-item>
      <!-- 同城 -->
      <el-form-item v-if="method.indexOf(20) >= 0" label="同城配送">
        <el-switch v-model="form.is_local" :inactive-value="10" :active-value="20" />
      </el-form-item>
      <el-form-item v-if="form.is_local == 20" label="同城运费模板" prop="local_template_id">
        <el-select
          v-model="form.local_template_id"
          placeholder="选择模板"
          style="width: 200px"
        >
          <el-option
            v-for="item in local"
            :key="item.id"
            :value="item.id"
            :label="item.name + ' ('+(item.method == 10 ? '按距离' : '按重量')+')'"
          />
        </el-select>
      </el-form-item>
      <!-- 自提 -->
      <el-form-item v-if="method.indexOf(30) >= 0" label="上门自提">
        <el-switch v-model="form.is_fetch" :inactive-value="10" :active-value="20" />
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
import { logistics, doLogistics } from '@/api/goods'

export default {
  name: 'GoodsEditLogistics',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      express: [],
      local: [],
      method: [],
      form: {
        id: null,
        express_template_id: null,
        local_template_id: null,
        is_express: 10,
        is_local: 10,
        is_fetch: 10
      },
      rules: {
        express_template_id: [{ required: true, message: '请选择快递运费模板', trigger: 'change' }],
        local_template_id: [{ required: true, message: '请选择同城运费模板', trigger: 'change' }]
      }
    }
  },
  created () {
    this.loading = true
    logistics(this.id)
      .then(res => {
        const { express, local, detail, method } = res.data
        this.form.id = detail.id
        this.express = express
        this.local = local
        this.method = method
        this.form.express_template_id = detail.express_template_id ? detail.express_template_id : null
        this.form.local_template_id = detail.local_template_id ? detail.local_template_id : null
        this.form.is_express = detail.is_express
        this.form.is_local = detail.is_local
        this.form.is_fetch = detail.is_fetch
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
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
          doLogistics(this.form).then(res => {
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

<style scoped>
/*  */
</style>

