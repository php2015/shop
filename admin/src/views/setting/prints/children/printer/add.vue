<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="打印机品牌" prop="brand">
          <el-radio-group v-model="form.brand" size="brand">
            <el-radio-button border label="feieyun">飞蛾云打印</el-radio-button>
            <el-radio-button border label="xpyun">芯烨云打印</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="打印机名称" prop="name">
          <el-input v-model.trim="form.name" clearable placeholder="打印机名称" style="width:80%" />
        </el-form-item>
        <el-form-item label="打印机底部编号" prop="sn">
          <el-input v-model.trim="form.sn" clearable placeholder="打印机编号" style="width:80%" />
        </el-form-item>
        <el-form-item v-if="form.brand == 'feieyun'" label="打印机底部Key" prop="key">
          <el-input v-model.trim="form.key" clearable placeholder="打印机Key" style="width:80%" />
        </el-form-item>
        <el-form-item label="打印机标签" prop="label">
          <el-input v-model.trim="form.label" clearable placeholder="打印机标签" style="width:80%" />
        </el-form-item>
        <el-form-item label="打印联数" prop="copies">
          <el-input-number v-model="form.copies" :min="0" label="打印联数" />
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-tooltip content="数值越小越靠前" placement="top">
            <i class="el-icon-question" />
          </el-tooltip>
        </el-form-item>
        <el-form-item label="状态" prop="status">
          <el-radio-group v-model="form.status">
            <el-radio-button label="10">下线</el-radio-button>
            <el-radio-button label="20">上线</el-radio-button>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <!-- 操作区 -->
      <footer>
        <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
        <el-button @click="beforeClose">取 消</el-button>
      </footer>
    </el-dialog>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/setting/printer'

export default {
  name: 'SettingPrintsPrinterAdd',
  components: {},
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        brand: 'feieyun',
        name: '',
        sn: '',
        key: '',
        label: '',
        copies: 1,
        sort: 100,
        status: 10
      },
      rules: {
        name: [{ required: true, message: '请输入打印机名称', trigger: 'blur' }],
        sn: [{ required: true, message: '请输入打印机底部编号', trigger: 'blur' }],
        key: [{ required: true, message: '请输入打印机底部Key', trigger: 'blur' }],
        label: [{ required: true, message: '请输入打印机标签', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      add()
        .then(res => {
          this.form.sort = res.data.sort
        })
        .finally(() => {
          this.loading = false
        })
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
            this.$parent.getList()
            this.beforeClose()
          })
            .finally(() => {
              this.submitLoading = false
            })
        } else {
          return false
        }
      })
    },

    beforeClose () {
      this.$emit('update:visible', false)
    },

    onSuccess (file) {
      this.form.image = file.response.data.file
    }
  }
}
</script>

<style scoped>
/*  */
</style>

