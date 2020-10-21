<template>
  <div class="app-container">
    <design @submit="handleSubmit" />
  </div>
</template>

<script>
import { design, doDesign } from '@/api/shop/page'
import Design from '@/components/Design'

export default {
  name: 'ShopPageDesign',
  components: {
    Design
  },
  data () {
    return {
      loading: false,
      submitLoading: false,
      form: {
        id: null,
        content: ''
      },
      rules: {}
    }
  },
  watch: {},
  created () {
    this.loading = true
    design(this.$route.params.id).then(res => {
      const { data } = res
      this.form.id = data.id
      const params = data.content ? data.content : [
        {
          id: 1,
          type: 'navigation',
          default: true, // 不能拖拽
          disabled: true, // 不能点击
          data: {
            app_name: data.title,
            app_skin: '#ffffff',
            navigation_bar_text_style: 'black'
          }
        }
      ]
      this.$store.dispatch('design/init', {
        params: params
      })
    })
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    handleSubmit (params) {
      this.loading = true
      this.form.content = JSON.stringify(params)
      doDesign(this.form).then(res => {
        this.$message({
          message: res.msg,
          type: 'success'
        })
      })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>

<style scoped>
/*  */
</style>

