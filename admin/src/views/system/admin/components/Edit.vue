<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="用户名" prop="username">
          <el-input v-model="form.username" placeholder="用户名" style="width:60%" />
        </el-form-item>
        <el-form-item label="用户密码" prop="password">
          <el-input v-model="form.password" type="password" placeholder="用户密码" style="width:60%" />
        </el-form-item>
        <el-form-item label="性别" prop="gender">
          <el-radio-group v-model="form.gender">
            <el-radio-button label="1">男</el-radio-button>
            <el-radio-button label="2">女</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="邮箱" prop="email">
          <el-input v-model="form.email" placeholder="邮箱" style="width:60%" />
        </el-form-item>
        <el-form-item label="手机号" prop="phone">
          <el-input v-model="form.phone" placeholder="手机号" style="width:60%" />
        </el-form-item>
        <el-form-item label="状态" prop="name">
          <el-radio-group v-model="form.status">
            <el-radio-button label="10">正常</el-radio-button>
            <el-radio-button label="20">冻结</el-radio-button>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div slot="footer">
        <el-button @click="beforeClose">取 消</el-button>
        <el-button type="primary" @click="handleSubmit">提 交</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { edit, detail } from '@/api/account'
import { validPhone, validEmail } from '@/utils/validate'

export default {
  name: 'AccountEdit',
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
    const phone = (rule, value, callback) => {
      if (value.length > 0) {
        if (validPhone(value)) {
          callback()
        } else {
          return callback(new Error('请输入正确的手机号'))
        }
      } else {
        callback()
      }
    }
    const email = (rule, value, callback) => {
      if (value.length > 0) {
        if (validEmail(value)) {
          callback()
        } else {
          return callback(new Error('请输入正确的E-Mail'))
        }
      } else {
        callback()
      }
    }
    return {
      loading: false,

      form: {
        username: '',
        password: '',
        gender: 1,
        email: '',
        phone: '',
        status: 10
      },
      rules: {
        username: [
          { required: true, message: '请输入用户名', trigger: 'blur' },
          { min: 3, max: 20, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        password: [
          { message: '请输入用户密码', trigger: 'blur' },
          {
            min: 6,
            max: 20,
            message: '长度在 6 到 20 个字符之间',
            trigger: 'blur'
          }
        ],
        email: [{ trigger: 'blur', validator: email }],
        phone: [{ trigger: 'blur', validator: phone }]
      }
    }
  },
  created () {
    this.detail(this.id)
  },
  methods: {
    detail (id) {
      this.loading = true
      detail(id)
        .then(res => {
          this.form = res.data
          this.form.status = res.data.status.value
        })
        .finally(() => {
          this.loading = false
        })
    },
    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.loading = true
          edit(this.form)
            .then(res => {
              this.$message({
                message: res.msg,
                type: 'success'
              })
              this.$parent.getList()
              this.beforeClose()
            })
            .finally(() => {
              this.loading = false
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

