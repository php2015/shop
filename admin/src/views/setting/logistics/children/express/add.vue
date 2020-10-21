<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" :fullscreen="true" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="10%">
        <el-form-item label="模板名称" prop="name">
          <el-input v-model.trim="form.name" clearable placeholder="模板名称" style="width:100%" />
        </el-form-item>
        <el-form-item label="是否包邮" prop="free">
          <el-radio-group v-model="form.free">
            <el-radio-button :label="10">不包邮</el-radio-button>
            <el-radio-button :label="20">包邮</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <section v-if="form.free == 10">
          <el-form-item label="计价方式" prop="method">
            <el-radio-group v-model="form.method">
              <el-radio-button :label="10">按件数</el-radio-button>
              <el-radio-button :label="20">按重量</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item prop="item">
            <div style="overflow-x: auto;">
              <table class="stock-table" cellspacing="0" cellpadding="0">
                <thead>
                  <tr>
                    <th style="min-width: 300px;">配送区域</th>
                    <th style="min-width: 100px;">{{ form.method == 10 ? '首件(件)' : '首重(Kg)' }}</th>
                    <th style="min-width: 100px;">首费(元)</th>
                    <th style="min-width: 100px;">{{ form.method == 10 ? '续件(件)' : '续重(Kg)' }}</th>
                    <th style="min-width: 100px;">续费(元)</th>
                    <th style="min-width: 100px;">操作</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in form.item" :key="index">
                    <td>
                      <el-cascader
                        :options="options"
                        style="width:80%"
                        :data-index="index"
                        :props="{
                          multiple: true,
                          value: 'label'
                        }"
                        clearable
                        collapse-tags
                        @change="selectRegion($event, index)"
                      />
                    </td>
                    <td>
                      <el-input-number v-model="item.first" :precision="form.method == 10 ? 0 : 2" :min="0" size="mini" />
                    </td>
                    <td>
                      <el-input-number v-model="item.first_fee" :precision="2" :min="0" size="mini" />
                    </td>
                    <td>
                      <el-input-number v-model="item.additional" :precision="form.method == 10 ? 0 : 2" :min="0" size="mini" />
                    </td>
                    <td>
                      <el-input-number v-model="item.additional_fee" :precision="2" :min="0" size="mini" />
                    </td>
                    <td>
                      <span v-if="index != 0" style="font-size: 20px; cursor: pointer;" @click="removeRow(index)">
                        <i class="el-icon-delete" />
                      </span>
                      <span v-else style="font-size: 20px; cursor: pointer;" @click="addRow()">
                        <i class="el-icon-circle-plus-outline" />
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="20" class="wh-foot" style="text-align: left;">
                      <span class="label">批量设置：</span>
                      <ul v-if="!batchSetting" class="set-list" style="margin-left: -50px;">
                        <li class="set-item" @click="batchSettingInput('first')">首件</li>
                        <li class="set-item" @click="batchSettingInput('first_fee')">首费</li>
                        <li class="set-item" @click="batchSettingInput('additional')">续件</li>
                        <li class="set-item" @click="batchSettingInput('additional_fee')">续费</li>
                      </ul>
                      <div v-else class="set-form">
                        <el-input
                          v-model="batchSettingValue"
                          size="mini"
                          placeholder="输入要设置的数量"
                          @keyup.enter.native="onBatchSetting"
                        />
                        <i class="set-btn blue el-icon-check" @click="onBatchSetting" />
                        <i class="set-btn red el-icon-close" @click="onBatchSettingCancel" />
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </el-form-item>
        </section>
        <el-form-item label="排序" prop="sort">
          <el-input-number v-model="form.sort" :min="0" label="数值越小越靠前" style="width: 200px;" />
          <el-tooltip content="数值越小越靠前" placement="top">
            <i class="el-icon-question" />
          </el-tooltip>
        </el-form-item>
      </el-form>
      <footer>
        <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
        <el-button @click="beforeClose">取 消</el-button>
      </footer>
    </el-dialog>
  </div>
</template>

<script>
import { add, doAdd } from '@/api/setting/logistics/express'
import { provinceAndCityData } from 'element-china-area-data'

export default {
  name: 'SettingLogisticsExpressAdd',
  components: {},
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      options: provinceAndCityData,
      batchSetting: false, // 是否打开批量设置输入框
      batchSettingValue: '', // 批量设置的值
      batchSettingType: '', // 设置的字段
      form: {
        name: '',
        free: 10,
        method: 10,
        sort: 100,
        item: [
          {
            region: [],
            first: 1,
            first_fee: 10,
            additional: 0,
            additional_fee: 0
          }
        ]
      },
      rules: {
        name: [{ required: true, message: '请输入模板名称', trigger: 'blur' }],
        free: [{ required: true, message: '请选择是否包邮', trigger: 'blur' }],
        method: [{ required: true, message: '请选择计价方式', trigger: 'blur' }]
      }
    }
  },
  created () {
    this.loading = true
    add()
      .then(res => {
        this.form.sort = res.data.sort
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    selectRegion (event, index) {
      this.form.item.forEach((item, i) => {
        if (index === i) {
          item.region = event
        }
      })
    },

    addRow () {
      this.form.item.push(
        {
          region: [],
          first: 1,
          first_fee: 10,
          additional: 0,
          additional_fee: 0
        }
      )
    },

    removeRow (index) {
      this.form.item.forEach((item, i) => {
        if (index === i) {
          this.form.item.splice(i, 1)
        }
      })
    },

    // 打开设置框
    batchSettingInput (type) {
      this.batchSettingType = type
      this.batchSetting = true
    },

    // 取消批量设置
    onBatchSettingCancel () {
      this.batchSettingValue = ''
      this.batchSettingType = ''
      this.batchSetting = false
    },

    // 批量设置
    onBatchSetting () {
      this.form.item.forEach(item => {
        item[this.batchSettingType] = this.batchSettingValue
      })
      this.onBatchSettingCancel()
    },

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.submitLoading = true
          doAdd(this.form).then(res => {
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
.stock-table {
  width: 100%;
  padding: 0;
  border-collapse: separate;
  border-color: #dfe6ec;
  border-style: solid;
  border-width: 1px 0 0 1px;
  background-color: #fff;
}
.stock-table td,
.stock-table th {
  padding: 4px 10px;
  border-bottom: 1px solid #dfe6ec;
  border-right: 1px solid #dfe6ec;
  text-align: center;
}
.stock-table th {
  line-height: 30px;
  background-color: #eef1f6;
}
.stock-table .link {
  cursor: pointer;
  color: #0088ee;
  font-size: 13px;
  margin-left: 6px;
}
.stock-table .wh-foot {
  line-height: 30px;
}
.stock-table .wh-foot .label {
  display: inline-block;
  vertical-align: top;
}
.stock-table .wh-foot .set-list {
  display: inline-block;
  vertical-align: top;
  font-size: 0;
}
.stock-table .wh-foot .set-list .set-item {
  display: inline-block;
  vertical-align: top;
  margin-left: 15px;
  font-size: 13px;
  cursor: pointer;
  color: #0088ee;
}
.stock-table .wh-foot .set-form {
  display: inline-block;
  margin-left: 10px;
}
.stock-table .wh-foot .set-form .el-input {
  display: inline-block;
  width: 120px;
}
.stock-table .wh-foot .set-form .set-btn {
  display: inline-block;
  padding: 0 2px;
  font-size: 15px;
  cursor: pointer;
}
.stock-table .wh-foot .set-form .set-btn.blue {
  color: #0088ee;
}
.stock-table .wh-foot .set-form .set-btn.red {
  color: #cc0000;
}
.stock-table .wh-foot .right {
  float: right;
}
.stock-table .wh-foot .text {
  font-size: 13px;
}
</style>

