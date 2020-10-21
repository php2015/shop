<template>
  <el-card style="margin-bottom:20px;">
    <div slot="header" class="clearfix">
      <span style="cursor: pointer;" @click="$router.push('/user')">
        <i class="el-icon-back" style="margin-right: 6px;" />返回
      </span>
    </div>

    <div class="user-profile">
      <div class="box-center">
        <el-avatar :src="detail.avatar_url" :size="80" />
      </div>
      <div class="box-center">
        <div class="user-name text-center">{{ detail.nickname }}</div>
        <div class="user-role text-center text-muted">{{ gender }}</div>
      </div>
    </div>

    <div class="user-bio">
      <div class="user-education user-bio-section">
        <div class="user-bio-section-header" />
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">ID: </span>{{ detail.id }}
        </div>
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">省份: </span>{{ detail.province }}
        </div>
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">城市: </span>{{ detail.city }}
        </div>
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">积分余额: </span>{{ detail.points }}
        </div>
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">佣金余额: </span>￥{{ detail.bonus }}
        </div>
        <div class="user-bio-section-body">
          <span class="user-bio-section-title">注册时间: </span>{{ detail.register_time }}
        </div>
      </div>
    </div>
  </el-card>
</template>

<script>
export default {
  components: {},
  props: {
    detail: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    gender () {
      if (this.detail.gender === 1) {
        return '男'
      } else if (this.detail.gender === 2) {
        return '女'
      }
      return '未知'
    }
  }
}
</script>

<style lang="scss" scoped>
 .box-center {
   margin: 0 auto;
   display: table;
 }

 .text-muted {
   color: #777;
 }

 .user-profile {
   .user-name {
     font-weight: bold;
   }

   .box-center {
     padding-top: 10px;
   }

   .user-role {
     padding-top: 10px;
     font-weight: 400;
     font-size: 14px;
   }

   .box-social {
     padding-top: 30px;

     .el-table {
       border-top: 1px solid #dfe6ec;
     }
   }

   .user-follow {
     padding-top: 20px;
   }
 }

 .user-bio {
   margin-top: 0px;
   color: #606266;

   span {
     padding-left: 4px;
   }

   .user-bio-section {
     font-size: 14px;
     padding: 15px 0;

     .user-bio-section-header {
       border-bottom: 1px solid #dfe6ec;
       padding-bottom: 10px;
       margin-bottom: 10px;
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
