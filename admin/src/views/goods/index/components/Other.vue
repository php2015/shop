<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <!-- 其他 -->
      <el-form-item label="初始销量" prop="sales_init">
        <el-input-number v-model="form.sales_init" :min="0" label="初始销量" style="width: 200px;" />
      </el-form-item>
      <el-form-item label="排序" prop="sort">
        <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
        <el-tooltip content="数值越小越靠前" placement="top">
          <i class="el-icon-question" />
        </el-tooltip>
      </el-form-item>
      <el-form-item label="状态" prop="status">
        <el-radio-group v-model="form.status">
          <el-radio-button :label="10">下架</el-radio-button>
          <el-radio-button :label="20">上架</el-radio-button>
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
        <div style="padding-top: 5px;">
          <el-alert :closable="false" type="info">
            <div slot="title">
              不选择时间为立即上架
            </div>
          </el-alert>
        </div>
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
import { other, doOther } from '@/api/goods'

export default {
  name: 'GoodsEditOther',
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
      form: {
        id: null,
        sales_init: 0,
        status: 10,
        sort: 0,
        sales_time: ''
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
        sales_init: [{ required: true, message: '请输入初始销量', trigger: 'blur' }],
        sort: [{ required: true, message: '请输入排序值', trigger: 'blur' }],
        status: [{ required: true, message: '状态', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    other(this.id)
      .then(res => {
        const { data } = res
        this.form.id = data.id
        this.form.sales_init = data.sales_init
        this.form.status = data.status
        this.form.sort = data.sort
        this.form.sales_time = data.sales_time
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
          doOther(this.form).then(res => {
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

