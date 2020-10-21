<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-button
        style="margin-left: 10px;"
        type="success"
        icon="el-icon-edit-outline"
        @click="$router.push('/system/module/add/')"
      >添加</el-button>
      <el-button
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-sort"
        @click="$router.push('/system/module/sort/')"
      >排序</el-button>
    </div>
    <el-divider />

    <!-- 警告 -->
    <el-alert
      title="如非系统开发人员，请勿修改本模块任何内容。"
      type="warning"
      show-icon
    />

    <!-- 列表 -->
    <el-table
      ref="table"
      v-loading="loading"
      :data="list"
      row-key="id"
      highlight-current-row
      :default-expand-all="expand_all"
      :tree-props="{children: 'children'}"
      border
      style="width: 100%"
    >
      <el-table-column label="名称" fixed="left" width="250">
        <template slot-scope="scope">
          <svg-icon :icon-class="scope.row.icon" style="position: relative;top:3px" />
          {{ scope.row.module_name }}
        </template>
      </el-table-column>
      <el-table-column prop="client_router" label="前端路由" align="center" />
      <el-table-column prop="server_router" label="后端路由" align="center" />
      <el-table-column label="类型" align="center">
        <template slot-scope="scope">
          <el-tag v-if="scope.row.level == 10" size="mini" type="primary">目录</el-tag>
          <el-tag v-if="scope.row.level == 20" size="mini" type="success">菜单</el-tag>
          <el-tag v-if="scope.row.level == 30" size="mini" type="danger">权限</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="权限继承" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.level == 20">
            <el-tag v-if="scope.row.extend == 10" size="mini" type="info">否</el-tag>
            <el-tag v-if="scope.row.extend == 20" size="mini" type="primary">是</el-tag>
          </section>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="240" align="center">
        <template slot-scope="scope">
          <el-link
            v-if="scope.row.level < 30 && scope.row.extend == 10"
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/system/module/add/' + scope.row.id)"
          >添加</el-link>
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/system/module/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link
            type="primary"
            icon="el-icon-sort"
            @click="$router.push('/system/module/sort/' + scope.row.id)"
          >排序</el-link>
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { list, doRemove } from '@/api/system/module'
import { batchHandle } from '@/utils'

export default {
  name: 'Module',
  components: {},
  mixins: [],
  props: {},
  data () {
    return {
      loading: false,
      expand_all: false,
      list: []
    }
  },
  computed: {},
  watch: {},
  created () {
    this.getList()
  },
  mounted () { },
  destroyed () { },
  methods: {
    getList () {
      this.loading = true
      list()
        .then(res => {
          this.list = res.data
        })
        .finally(() => {
          this.loading = false
        })
    },

    handleRemove (data) {
      batchHandle(data, '确定删除吗？').then(id => {
        this.loading = true
        doRemove(id).then(res => {
          this.$message({
            message: res.msg,
            type: 'success'
          })
          this.getList()
        })
          .finally(() => {
            this.loading = false
          })
      })
    }
  }
}
</script>

<style>
/* ... */
</style>
