<template>
  <div class="user-activity">
    <section v-if="invoice">
      <div class="user-bio">
        <div class="user-education user-bio-section">
          <div class="user-bio-section-header" />
          <section v-if="invoice.category == 10">
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">类型: </span>个人
            </div>
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">名称: </span>{{ invoice.title }}
            </div>
          </section>
          <section v-if="invoice.category == 20">
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">抬头: </span>单位
            </div>
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">单位名称: </span>{{ invoice.title }}
            </div>
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">纳税人识别号: </span>{{ invoice.tax_no }}
            </div>
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">开户行: </span>{{ invoice.bank_name ? invoice.bank_name : '-' }}
            </div>
            <div class="user-bio-section-body">
              <span class="user-bio-section-title">银行账号: </span>{{ invoice.bank_account ? invoice.bank_account : '-' }}
            </div>
          </section>
          <div class="user-bio-section-body">
            <span class="user-bio-section-title">邮箱: </span>{{ invoice.email ? invoice.email : '-' }}
          </div>
          <div class="user-bio-section-body">
            <span class="user-bio-section-title">电话号码: </span>{{ invoice.phone ? invoice.phone : '-' }}
          </div>
        </div>
      </div>
    </section>
    <section v-else>暂无发票信息</section>
  </div>
</template>

<script>
export default {
  components: {},
  props: {
    invoice: {
      type: Object,
      default: () => {}
    }
  },
  computed: {}
}
</script>

<style lang="scss" scoped>
.user-activity {
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;

    .image {
      width: 100%;
      height: 100%;

    }

    .user-images {
      padding-top: 20px;
    }
  }

  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;

    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }

    .link-black {

      &:hover,
      &:focus {
        color: #999;
      }
    }
  }

}

.box-center {
  margin: 0 auto;
  display: table;
}

.text-muted {
  color: #777;
}

.user-bio {
   margin-top: 0px;
   color: #606266;

   span {
     padding-left: 4px;
   }

   .user-bio-section {
     font-size: 14px;

     .user-bio-section-header {
       font-weight: bold;
     }

     .user-bio-section-body {
       padding: 10px 0 10px 0;
       word-wrap: break-word;
     }

     .user-bio-section-title {
       font-weight: bold;
     }
   }
 }
</style>
