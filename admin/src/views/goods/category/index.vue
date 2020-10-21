<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-button
        style="margin-left: 10px;"
        type="success"
        icon="el-icon-edit-outline"
        @click="$router.push('/goods/category/add/')"
      >添加</el-button>
      <el-button
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-sort"
        @click="$router.push('/goods/category/sort/')"
      >排序</el-button>
    </div>
    <el-divider />

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
      <el-table-column label="名称 (ID)">
        <template slot-scope="scope">
          {{ scope.row.category_name }} (ID:{{ scope.row.id }})
        </template>
      </el-table-column>
      <el-table-column label="分类图片" align="center">
        <template slot-scope="scope">
          <section v-if="scope.row.image">
            <el-image
              style="width: 38px; height: 38px"
              :src="scope.row.image_url"
              :preview-src-list="[scope.row.image_url]"
            />
          </section>
          <section v-else>
            无
          </section>
        </template>
      </el-table-column>
      <el-table-column prop="goods_count" label="关联商品数量" align="center" />
      <el-table-column prop="sort" label="排序" align="center" />
      <el-table-column prop="status" label="状态" align="center">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.status"
            active-color="#13ce66"
            :inactive-value="10"
            :active-value="20"
            @change="handleStatus(scope, 'status')"
          />
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="280" align="center">
        <template slot-scope="scope">
          <el-link
            v-if="scope.row.level < 1"
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/goods/category/add/' + scope.row.id)"
          >添加下级</el-link>
          <el-link
            v-if="scope.row.level < 1"
            type="primary"
            icon="el-icon-sort"
            @click="$router.push('/goods/category/sort/' + scope.row.id)"
          >排序下级</el-link>
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/goods/category/edit/' + scope.row.id)"
          >编辑</el-link>
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { list, doStatus, doRemove } from '@/api/goods/category'
import { batchHandle } from '@/utils'

export default {
  name: 'GoodsCategory',
  data () {
    return {
      loading: false,
      expand_all: false,
      list: []
    }
  },
  created () {
    this.getList()
  },
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
      batchHandle(data).then((id) => {
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
    },

    handleStatus (scope, field) {
      this.loading = true
      doStatus(scope.row.id, field)
        .then(res => {})
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<style>
/* ... */
</style>
