<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-form-item label="调整前积分">
        {{ points }}
      </el-form-item>
      <el-form-item label="调整积分" prop="points">
        <el-input-number v-model="form.points" :min="-points" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="调整积分可输入正负值，负值为扣减积分,扣减积分不能超过用户总积分数" />
        </div>
      </el-form-item>
      <el-form-item label="备注说明" prop="intro">
        <el-input v-model="form.intro" clearable placeholder="备注说明" style="width:60%" />
        <div style="padding-top: 10px;">
          <el-alert :closable="false" type="info" title="该说明将会显示在用户积分列表中" />
        </div>
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.push('/user')">取 消</el-button>
    </footer>
  </div>
</template>

<script>
import { points, doPoints } from '@/api/user/edit'

export default {
  name: 'UserEditTag',
  components: {},
  data () {
    const points = (rule, value, callback) => {
      if (value === 0) {
        callback(new Error('请输入不等于0的积分数'))
      } else {
        callback()
      }
    }
    return {
      loading: false,
      submitLoading: false,
      points: 0,
      form: {
        id: null,
        points: 0,
        intro: ''
      },
      rules: {
        points: [{ required: true, trigger: 'blur', validator: points }],
        intro: [{ required: true, message: '请输入备注说明信息', trigger: 'blur' }]
      }
    }
  },
  watch: {
    property: {
      immediate: true,
      handler (value) {
        this.loading = true
        points(this.$route.params.id).then(res => {
          const { data } = res
          this.points = data.points
          this.form.id = data.id
        })
          .finally(() => {
            this.loading = false
          })
      }
    }
  },
  created () {},
  methods: {
    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          doPoints(this.form).then(res => {
            this.points += this.form.points
            this.form.points = 0
            this.form.intro = ''

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
    },

    getTag (data) {
      const result = []
      data.forEach(item => {
        result.push(item.id)
      })
      return result
    }
  }
}
</script>

<style scoped>
/*  */
</style>
