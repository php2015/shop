<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-position="top">
      <el-form-item label="签到积分" prop="checkin">
        <div v-for="(item, index) in form.checkin" :key="index" style="line-height: 40px;">
          <div
            class="el-input el-input--mini el-input-group el-input-group--prepend"
            style="width: 200px;"
          >
            <div class="el-input-group__prepend">第 {{ index + 1 }} 天</div>
            <input
              ref="points"
              type="number"
              autocomplete="off"
              placeholder="请输入积分"
              class="el-input__inner"
              name="points[]"
              :value="item"
            >
          </div>
        </div>
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="连续签到7天后，将按照最高积分连续发放。" />
        </div>
      </el-form-item>
      <!-- <el-form-item label="邀请新用户" prop="invite">
        <el-input-number v-model.number="form.invite" :min="0" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="邀请新用户，邀请者获得积分数。新用户需要授权登录。" />
        </div>
      </el-form-item> -->
      <el-form-item label="规则说明" prop="content">
        <tinymce v-model="content" :height="300" />
      </el-form-item>
    </el-form>
    <div class="footer">
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">保存设置</el-button>
    </div>
  </div>
</template>

<script>
import { get, save } from '@/api/setting'
import Tinymce from '@/components/Tinymce'

export default {
  name: 'SettingAppOrder',
  components: {
    Tinymce
  },
  data () {
    const validPoints = (rule, value, callback) => {
      let status = true
      this.$refs.points.forEach(item => {
        if (!item.value) {
          status = false
        }
      })
      if (!status) {
        callback(new Error('请输入正确的签到积分'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      content: '',
      form: {
        checkin: [1, 2, 3, 4, 5, 6, 7],
        content: ''
      },
      rules: {
        checkin: [{ required: true, trigger: 'blur', validator: validPoints }]
      }
    }
  },
  watch: {
    content () {
      this.form.content = encodeURIComponent(this.content)
    }
  },
  created () {
    this.init()
  },
  methods: {
    init () {
      this.loading = true
      get('app.points').then(res => {
        if (res.data) {
          this.form = res.data
          this.content = res.data.content
        }
      })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          const points = []
          this.$refs.points.forEach(item => {
            points.push(item.value)
          })
          this.form.checkin = points
          this.submitLoading = true
          save('app.points', this.form).then(res => {
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

