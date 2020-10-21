<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item prop="template" label-width="0">
        <el-table
          :data="form.template"
        >
          <el-table-column prop="title" label="标题" width="200" align="center" />
          <el-table-column label="模板ID" align="center">
            <template slot-scope="scope">
              <el-input v-model.trim="scope.row.value" clearable placeholder="模板ID" />
            </template>
          </el-table-column>
          <el-table-column prop="detail" label="关键词" align="center" />
        </el-table>
      </el-form-item>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'

export default {
  name: 'SettingMessageWx',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        driver: 'wx',
        template: []
      },
      rules: {}
    }
  },
  created () {
    this.loading = true
    get('message.wx').then(res => {
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
          save('message.wx', this.form).then(res => {
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

