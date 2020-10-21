<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
      <el-form-item label="回复" prop="reply_content">
        <el-input
          v-model="form.reply_content"
          type="textarea"
          :autosize="{ minRows: 2, maxRows: 4}"
          placeholder="请输入回复内容"
          style="width:80%"
        />
      </el-form-item>
    </el-form>
    <!-- 操作区 -->
    <footer>
      <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
      <el-button @click="$router.go(-1)">返 回</el-button>
    </footer>
  </div>
</template>

<script>
import { doReply } from '@/api/order/comment'

export default {
  name: 'OrderCommentReply',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      detail: {},
      form: {
        id: null,
        reply_content: ''
      },
      rules: {
        id: [{ required: true, message: 'ID为空', trigger: 'blur' }],
        reply_content: [{ required: true, message: '请输入回复内容', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.form.id = this.$route.params.id
  },
  methods: {
    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          doReply(this.form).then(res => {
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

