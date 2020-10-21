<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :before-close="beforeClose" width="80%">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="协议名称" prop="rule_name">
          <el-input v-model.trim="form.rule_name" clearable placeholder="协议名称" style="width:80%" />
        </el-form-item>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-tooltip content="数值越小越靠前" placement="top">
            <i class="el-icon-question" />
          </el-tooltip>
        </el-form-item>
        <el-form-item label="内容" prop="content">
          <tinymce v-model="content" :height="300" />
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
import { edit, doEdit } from '@/api/setting/rule'
import Tinymce from '@/components/Tinymce'

export default {
  name: 'SettingAppRuleEdit',
  components: {
    Tinymce
  },
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
      content: '',
      form: {
        rule_name: '',
        sort: 100,
        content: ''
      },
      rules: {
        rule_name: [{ required: true, message: '请输入协议名称', trigger: 'blur' }]
      }
    }
  },
  watch: {
    content () {
      this.form.content = encodeURIComponent(this.content)
    }
  },
  created () {
    this.loading = true
    edit(this.id)
      .then(res => {
        this.form = res.data
        this.content = res.data.content
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

