<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="锁定账户" prop="lock">
        <el-radio-group v-model="form.lock">
          <el-radio-button label="10">不锁定</el-radio-button>
          <el-radio-button label="20">锁定</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item v-if="form.lock == 20" label="锁定策略">
        在
        <el-input-number
          v-model="form.limited_time_length"
          controls-position="right"
          size="small"
          :min="15"
          :max="60"
          style="width:100px;"
        />分钟内， 登录失败
        <el-input-number
          v-model="form.fail_times"
          controls-position="right"
          size="small"
          :min="3"
          :max="10"
          style="width:100px;"
        />次， 锁定账号
        <el-input-number
          v-model="form.lock_time_length"
          controls-position="right"
          size="small"
          :min="15"
          :max="60"
          style="width:100px;"
        />分钟。
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
  name: 'SettingSystemSecurity',
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        lock: 10,
        limited_time_length: 15,
        fail_times: 3,
        lock_time_length: 10
      },
      rules: {}
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('system.security').then(res => {
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
          save('system.security', this.form).then(res => {
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

