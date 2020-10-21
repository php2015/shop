<template>
  <div class="app-container">
    <section v-loading="loading">
      <el-row :gutter="20">
        <el-col :span="6" :xs="24">
          <Card :detail="detail" />
        </el-col>

        <el-col :span="18" :xs="24">
          <el-card>
            <el-tabs>
              <el-tab-pane label="收货地址">
                <Address :address="detail.address" />
              </el-tab-pane>
              <el-tab-pane label="发票信息">
                <Invoice :invoice="detail.invoice" />
              </el-tab-pane>
            </el-tabs>
          </el-card>
        </el-col>
      </el-row>
    </section>
  </div>
</template>c

<script>
import { detail } from '@/api/user/detail'
import Card from './components/Card'
import Address from './components/Address'
import Invoice from './components/Invoice'
// import { mapGetters } from 'vuex'

export default {
  name: 'UserDetailIndex',
  components: {
    Card,
    Address,
    Invoice
  },
  data () {
    return {
      loading: false,
      active: 'active',
      detail: {}
    }
  },
  computed: {
    // ...mapGetters([
    //   'name',
    //   'avatar'
    // ])
  },
  created () {
    this.loading = true
    detail(this.$route.params.id)
      .then(res => {
        this.detail = res.data
      })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {}
}
</script>
