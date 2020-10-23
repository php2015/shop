<template>
  <div class="app-container">
    <el-dialog :title="title" :visible.sync="visible" width="60%" :before-close="beforeClose">
      <el-form ref="form" v-loading="loading" :model="form" :rules="rules" label-width="20%">
        <el-form-item label="模板名称" prop="name">
          <el-input v-model.trim="form.name" clearable placeholder="模板名称" style="width:100%" />
        </el-form-item>
        <el-form-item label="计价方式" prop="method">
          <el-radio-group v-model="form.method">
            <el-radio-button :label="10">按距离</el-radio-button>
            <el-radio-button :label="20">按重量</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item v-if="form.method == 20" label="最大可配送距离" prop="distance">
          <el-input-number v-model="form.distance" :min="0" size="mini" /> km
        </el-form-item>
        <el-form-item v-if="form.method == 10" label="最大可配送重量" prop="weight">
          <el-input-number v-model="form.weight" :precision="2" :min="0" size="mini" /> kg
        </el-form-item>
        <el-form-item prop="item">
          <div style="overflow-x: auto;">
            <table class="stock-table" cellspacing="0" cellpadding="0">
              <thead>
                <tr>
                  <th style="min-width: 300px;">规则</th>
                  <th style="min-width: 100px;">操作</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in form.item" :key="index">
                  <td>
                    {{ item.min }} ≤ {{ form.method == 10 ? 'd' : 'w' }} ≤
                    <el-input-number v-model="item.max" :precision="form.method == 10 ? 0 : 2" :min="0" size="mini" />
                    {{ form.method == 10 ? 'km' : 'kg' }}，收取配送费
                    <el-input-number v-model="item.fee" :precision="2" :min="0" size="mini" /> 元
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
              </tbody>
            </table>
          </div>
        </el-form-item>
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
import { add, doAdd } from '@/api/setting/logistics/local'

export default {
  name: 'SettingLogisticsLocalAdd',
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
      form: {
        name: '',
        free: 10,
        method: 10,
        distance: 0,
        weight: 0,
        sort: 100,
        item: [
          {
            min: 0,
            max: 0,
            fee: 0
          }
        ]
      },
      rules: {
        name: [{ required: true, message: '请输入模板名称', trigger: 'blur' }],
        free: [{ required: true, message: '请选择是否包邮', trigger: 'blur' }],
        method: [{ required: true, message: '请选择计价方式', trigger: 'change' }],
        distance: [{ required: true, message: '请输入最大可配送距离', trigger: 'blur' }],
        weight: [{ required: true, message: '请输入最大可配送重量', trigger: 'blur' }]
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
    addRow () {
      const last = this.form.item[this.form.item.length - 1].max
      if (last === 0) {
        this.$message.warning('下一个区间不应该从0开始')
        return false
      }
      this.form.item.push(
        {
          min: last,
          max: 0,
          fee: 0
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

    handleSubmit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          if (this.form.free === 10) {
            let max = 0
            let check = true
            this.form.item.forEach((item, index) => {
              if (item.min >= item.max) {
                check = false
              }
              max = item.max
            })
            if (!check) {
              this.$message.warning('区间起始值应该小于结束值，请查看规则设置')
              return false
            }
            this.form.method === 10 ? this.form.distance = max : this.form.weight = max
          }
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

