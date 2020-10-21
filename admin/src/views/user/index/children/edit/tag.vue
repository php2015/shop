<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules">
      <el-form-item label="用户标签" prop="title">
        <el-select v-model="form.tag" multiple placeholder="请选择" style="width:80%">
          <el-option
            v-for="item in list"
            :key="item.id"
            :label="item.tag_name"
            :value="item.id"
          />
        </el-select>
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
import { tag, doTag } from '@/api/user/edit'

export default {
  name: 'UserEditTag',
  components: {},
  data () {
    return {
      loading: false,
      submitLoading: false,
      list: [],
      form: {
        id: null,
        tag: []
      },
      rules: {}
    }
  },
  watch: {
    property: {
      immediate: true,
      handler (value) {
        this.loading = true
        tag(this.$route.params.id).then(res => {
          const { list, detail } = res.data
          this.list = list
          this.form.tag = this.getTag(detail.tag)
          this.form.id = detail.id
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
          doTag(this.form).then(res => {
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
