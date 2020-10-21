<template>
  <div>
    <!-- <div style="padding: 10px 0;">
      <el-alert :closable="false" type="info">
        <div slot="title" style="line-height: 30px;">默认选择公开的优惠卷。</div>
      </el-alert>
    </div> -->
    <div>
      <el-tag v-for="item in params" :key="item.id" closable :type="item.coupon_type == 10 ? 'danger' : 'warning'" class="coupon-tag" @close="remove(item.id)">
        <span v-if="item.condition > 0">
          满￥{{ item.condition }}元
        </span>
        <span v-else>
          无门槛
        </span>
        <span v-if="item.coupon_type == 10">
          减￥{{ item.amount }}元
        </span>
        <span v-else>
          打{{ item.discount }}折
        </span>
      </el-tag>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlaceholderCoupon',
  components: {},
  mixins: [],
  props: {
    params: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {

    }
  },
  computed: {},
  watch: {},
  created () { },
  methods: {
    click () {
      this.$emit('click')
    },

    remove (id) {
      this.params.forEach((item, index) => {
        if (item.id === id) {
          this.params.splice(index, 1)
        }
      })
    }
  }
}
</script>

<style>
.coupon-tag {
  margin: 5px 5px;
}
</style>
