<template>
  <div>
    <el-tabs>
      <el-tab-pane label="商品分组" />
      <el-tab-pane label="商品分组" />
      <el-tab-pane label="商品分组" />
      <el-tab-pane label="商品分组" />
    </el-tabs>
    <div v-if="params.layout == 1">
      <div v-for="n in 2" :key="n" style="display: flex; border:1px solid #efefef">
        <div style="width: 30%;">
          <el-image style="width: 100%; height: 120px;" src="" fit="fill">
            <div slot="error" class="goods-slot">
              <i class="el-icon-picture" />
            </div>
          </el-image>
        </div>
        <div style="width: 70%; background: #fff; line-height: 25px; font-size: 14px; padding: 5px; color: #353535;">
          <div v-if="params.field.indexOf('goods_name') >= 0">商品名称</div>
          <div v-if="params.field.indexOf('subtitle') >= 0" style="color: #999;">商品副标题</div>
          <div style="display: flex;">
            <div v-if="params.field.indexOf('sales_price') >= 0" style="color: red;">￥12</div>
            <div v-if="params.field.indexOf('line_price') >= 0" style="color: #666; text-decoration:line-through; padding-left: 10px;">￥32</div>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 12px;">
            <div v-if="params.field.indexOf('sales') >= 0" style="color: #999; padding-left: 5px;">已售：88</div>
            <div v-if="params.field.indexOf('stock') >= 0" style="color: #999; padding-right: 5px;">库存：168</div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="params.layout == 2">
      <div style="display: flex;">
        <div v-for="n in 2" :key="n" class="goods-item" style="min-width: 50%; display: flex; flex-direction: column; padding: 5px; color: #353535;">
          <el-image style="width: 100%; height: 180px;" src="" fit="fill">
            <div slot="error" class="goods-slot">
              <i class="el-icon-picture" />
            </div>
          </el-image>
          <div style="background: #fff; line-height: 25px; font-size: 14px; padding: 5px;">
            <div v-if="params.field.indexOf('goods_name') >= 0">商品名称</div>
            <div v-if="params.field.indexOf('subtitle') >= 0" style="color: #999;">商品副标题</div>
            <div style="display: flex;">
              <div v-if="params.field.indexOf('sales_price') >= 0" style="color: red;">￥12</div>
              <div v-if="params.field.indexOf('line_price') >= 0" style="color: #999; text-decoration:line-through; padding-left: 10px;">￥32</div>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12px;">
              <div v-if="params.field.indexOf('sales') >= 0" style="color: #999; padding-left: 5px;">已售：88</div>
              <div v-if="params.field.indexOf('stock') >= 0" style="color: #999; padding-right: 5px;">库存：168</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PreviewGoodsGroup',
  components: {},
  props: {
    id: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {}
  },
  computed: {
    params () {
      let data = {}
      this.$store.state.design.params.forEach(item => {
        if (item.id === this.id) {
          data = item.data
        }
      })
      return data
    }
  },
  watch: {},
  created () { },
  methods: {}
}
</script>

<style>
.goods-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: #90a8da;
  color: #fff;
  font-size: 50px;
}
</style>

