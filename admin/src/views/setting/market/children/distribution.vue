<template>
  <div class="app-container">
    <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="120px">
      <el-tabs type="border-card">
        <el-tab-pane label="基础设置">
          <el-form-item label="分销功能" prop="distribution_status">
            <el-radio-group v-model="form.distribution_status">
              <el-radio-button :label="10">关闭</el-radio-button>
              <el-radio-button :label="20">开启</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="加入分销商" prop="distribution_join">
            <el-radio-group v-model="form.distribution_join">
              <el-radio-button :label="10">不需审核</el-radio-button>
              <el-radio-button :label="20">需审核</el-radio-button>
            </el-radio-group>
          </el-form-item>
        </el-tab-pane>
        <el-tab-pane label="佣金设置">
          <el-form-item label="分销佣金类型" prop="distribution_type">
            <el-radio-group v-model="form.distribution_type">
              <el-radio-button :label="10">百分比</el-radio-button>
              <el-radio-button :label="20">固定金额</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="一级佣金" prop="level_one">
            <el-input-number v-model="form.level_one" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" label="一级佣金" />
          </el-form-item>
          <el-form-item label="二级佣金" prop="level_two">
            <el-input-number v-model="form.level_two" :precision="form.distribution_type == 10 ? 0 : 2" :min="0" label="一级佣金" />
          </el-form-item>
        </el-tab-pane>
        <el-tab-pane label="规则协议">
          <el-form-item prop="content" label-width="0px">
            <tinymce v-model="content" :height="300" />
          </el-form-item>
        </el-tab-pane>
      </el-tabs>
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
  name: 'SettingMarketDistribution',
  components: {
    Tinymce
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      content: '',
      form: {
        distribution_status: 10,
        distribution_join: 10,
        distribution_type: 10,
        level_one: 0,
        level_two: 0,
        content: ''
      },
      rules: {
        distribution_status: [{ required: true, message: '请选择是否开启分销', trigger: 'change' }],
        distribution_join: [{ required: true, message: '请选择加入分销条件', trigger: 'change' }],
        distribution_type: [{ required: true, message: '请选择分销佣金类型', trigger: 'change' }],
        level_one: [{ required: true, message: '请输入一级佣金', trigger: 'blur' }],
        level_two: [{ required: true, message: '请输入二级佣金', trigger: 'blur' }]
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
      get('market.distribution')
        .then(res => {
          if (res.data) {
            this.form.distribution_status = res.data.distribution_status
            this.form.distribution_join = res.data.distribution_join
            this.form.distribution_type = res.data.distribution_type
            this.form.level_one = res.data.level_one
            this.form.level_two = res.data.level_two
            this.content = res.data.content
          }
        })
        .finally(() => {
          this.loading = false
        })
    },

    handleSubmit () {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.submitLoading = true
          save('market.distribution', this.form)
            .then(res => {
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

