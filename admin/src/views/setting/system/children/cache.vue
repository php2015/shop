<template>
  <div>
    <el-table
      ref="table"
      v-loading="loading"
      :data="list"
      stripe
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column prop="type" label="类型" width="200" />
      <el-table-column prop="intro" label="说明" />
      <el-table-column label="操作" width="200">
        <template slot-scope="scope">
          <el-button size="mini" round type="danger" @click="handleSubmit(scope.row.key)">清除缓存</el-button>
        </template>
        <el-button size="mini" round type="danger">清除缓存</el-button>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { doFlush } from '@/api/setting'
import { removeToken } from '@/utils/user'

export default {
  name: 'SettingSystemCache',
  data () {
    return {
      loading: false,
      list: [{
        key: 'business',
        type: '业务缓存',
        intro: '一般为前端业务性缓存，存储介质为Redis。清除此类缓存没有影响。'
      }, {
        key: 'system',
        type: '系统缓存',
        intro: '一般为后端系统性缓存，存储介质为File。如：用户Token、系统设置项等。清除此类缓存会影响前端业务，谨慎清理！'
      }]
    }
  },
  created () { },
  methods: {
    handleSubmit (key) {
      this.$confirm('确定删除该缓存吗？', '系统提示', {
        confirmButtonText: '清除',
        cancelButtonText: '取消',
        type: 'warning'
      })
        .then(() => {
          this.loading = true
          doFlush(key).then(res => {
            this.$message({
              message: '清除完成',
              type: 'success'
            })
            removeToken()
            this.$router.push('/login')
          })
            .finally(() => {
              this.loading = false
            })
        })
        .catch(() => {
          return false
        })
    }
  }
}
</script>

<style>
/*  */
</style>

