<template>
  <div class="app-container">
    <!-- 查询 -->
    <div class="filter-container">
      <el-input
        v-model="query.content"
        placeholder="评论内容"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-input
        v-model="query.reply_content"
        placeholder="回复内容"
        style="width: 200px;"
        class="filter-item"
        clearable
        @keyup.enter.native="handleSearch"
      />
      <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
      <el-button
        style="margin-left: 10px;"
        type="danger"
        icon="el-icon-delete"
        @click="handleRemove"
      >删除</el-button>
    </div>
    <el-divider />

    <!-- 列表 -->
    <el-table
      ref="table"
      v-loading="loading"
      stripe
      border
      highlight-current-row
      :data="list"
      style="width: 100%"
      @sort-change="sortChange"
    >
      <el-table-column type="expand">
        <template slot-scope="props">
          <div v-if="props.row.images.length > 0" style="display: flex; justify-content: flex-start; flex-wrap: wrap;">
            <div v-for="item in props.row.images" :key="item.id" class="order_goods">
              <el-card :body-style="{ padding: '0px' }">
                <el-image
                  style="width: 100px; height: 100px"
                  :src="item.image_url"
                  :preview-src-list="[item.image_url]"
                />
              </el-card>
            </div>
          </div>
          <div v-else>
            <el-alert
              title="用户未上传图片"
              :closable="false"
              type="info"
              center
              show-icon
            />
          </div>
        </template>
      </el-table-column>
      <el-table-column prop="goods.goods_name" label="商品" />
      <el-table-column label="评分" align="center" sortable="custom" width="200">
        <template slot-scope="scope">
          <el-rate
            v-model="scope.row.rate"
            disabled
            show-score
            text-color="#ff9900"
          />
        </template>
      </el-table-column>
      <el-table-column prop="user.nickname" label="用户" align="center" />
      <el-table-column prop="content" label="评价内容" align="center" />
      <el-table-column prop="comment_time" label="评价时间" align="center" sortable="custom" />
      <el-table-column prop="reply_content" label="回复内容" align="center" />
      <el-table-column prop="reply_time" label="回复时间" align="center" sortable="custom" />
      <el-table-column label="置顶" align="center" sortable="custom">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.top"
            active-color="#13ce66"
            :inactive-value="10"
            :active-value="20"
            @change="handleStatus(scope, 'top')"
          />
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" width="150" align="center">
        <template slot-scope="scope">
          <el-link
            type="primary"
            icon="el-icon-edit-outline"
            @click="$router.push('/order/comment/reply/' + scope.row.id)"
          >回复</el-link>
          <el-link type="danger" icon="el-icon-delete" @click="handleRemove(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
    <!-- 分页 -->
    <pagination
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import { list, doStatus, doRemove } from '@/api/order/comment'
import { batchHandle } from '@/utils'
import Pagination from '@/components/Pagination'

export default {
  name: 'OrderComment',
  components: { Pagination },
  data () {
    return {
      loading: false,
      list: null,
      total: 0,
      page_total: 0,
      query: {
        page: 1,
        limit: 10,
        sort: 'id:desc'
      },
      inputValue: ''
    }
  },
  created () {
    this.getList()
  },
  methods: {
    getList () {
      this.loading = true
      list(this.query)
        .then(res => {
          this.list = res.data.data
          this.total = res.data.total
          this.page_total = res.data.last_page
        })
        .finally(() => {
          this.loading = false
        })
    },

    sortChange (data) {
      const { prop, order } = data
      if (order !== null) {
        if (order === 'ascending') {
          this.query.sort = prop + ':asc'
        } else {
          this.query.sort = prop + ':desc'
        }
        this.handleSearch()
      } else {
        this.query.sort = 'id:desc'
        this.handleSearch()
      }
    },

    handleSearch () {
      this.query.page = 1
      this.getList()
    },

    handleRemove (data) {
      const params = typeof data === 'object' ? this.$refs.table.selection : data
      batchHandle(params, '确定删除吗？').then(id => {
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
.price {
  font-size: 13px;
  color: red;
}

.total {
  padding: 0;
  float: right;
  font-size: 13px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
}

.image {
  width: 100%;
  display: block;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}

.clearfix:after {
  clear: both;
}

.order_goods {
  width: 120px;
  padding: 0 20px 20px 0;
}

.order_goods_name {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}
</style>
