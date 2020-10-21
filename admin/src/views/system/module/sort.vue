<template>
  <div>
    <div v-if="list !== null && list.length === 0" style="padding:50px;">
      <el-alert title="没有可排序的模块" type="error" center show-icon :closable="false" />
      <!-- 操作区 -->
      <footer>
        <el-button @click="$router.go(-1)">取 消</el-button>
      </footer>
    </div>
    <div v-if="list !== null && list.length > 0">
      <draggable v-model="list" v-loading="loading" style="padding:50px;">
        <el-alert
          v-for="element in list"
          :key="element.id"
          :title="element.module_name"
          type="info"
          :closable="false"
          style="margin:10px;cursor:s-resize;"
        />
      </draggable>

      <!-- 操作区 -->
      <footer>
        <el-button type="primary" :loading="submitLoading" @click="handleSubmit">提 交</el-button>
        <el-button @click="$router.go(-1)">取 消</el-button>
      </footer>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import { sort, doSort } from '@/api/system/module'

export default {
  name: 'ModuleSort',
  components: {
    draggable
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      list: null
    }
  },
  created () {
    this.loading = true
    const id = this.$route.params.pathMatch ? this.$route.params.pathMatch : 0
    sort(id).then(res => {
      this.list = res.data
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit () {
      if (this.list.length > 0) {
        const id = []
        this.list.forEach(item => {
          id.push(item.id)
        })
        this.submitLoading = true
        doSort(id.toString()).then(res => {
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
        this.$message({
          message: '没有可排序的模块',
          type: 'error'
        })
      }
    }
  }
}
</script>

<style>
/* ... */
</style>
