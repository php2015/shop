<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="分类名称" prop="category_name">
          <el-input v-model.trim="form.category_name" clearable placeholder="分类名称" style="width:80%" />
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-tooltip content="数值越小越靠前" placement="top">
            <i class="el-icon-question" />
          </el-tooltip>
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
import { edit, doEdit } from '@/api/setting/feedback'

export default {
  name: 'SettingAppFeedbackEdit',
  components: {},
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    },
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
        category_name: '',
        sort: 100
      },
      rules: {
        category_name: [{ required: true, message: '请输入分类名称', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    edit(this.id)
      .then(res => {
        this.form = res.data
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
          doEdit(this.form).then(res => {
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
    }
  }
}
</script>

<style scoped>
/*  */
</style>

