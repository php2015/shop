<template>
  <div class="user-activity">
    <section v-if="address.length">
      <div v-for="item in address" :key="item.id" class="post">
        <div class="user-block">
          <span class="username text-muted">{{ item.contact }}</span>
          <span class="description">{{ item.phone }}</span>
        </div>
        <p>
          {{ item.province }}{{ item.city }}{{ item.district }}{{ item.detail }}
        </p>
      </div>
    </section>
    <section v-else>暂无收货地址</section>
  </div>
</template>

<script>
export default {
  components: {},
  props: {
    address: {
      type: Array,
      default: () => []
    }
  },
  computed: {}
}
</script>

<style lang="scss" scoped>
.user-activity {
  .user-block {

    .username,
    .description {
      display: block;
      margin-left: 0px;
      padding: 2px 0;
    }

    .username{
      font-size: 16px;
      color: #000;
    }

    :after {
      clear: both;
    }

    .img-circle {
      border-radius: 50%;
      width: 40px;
      height: 40px;
      float: left;
    }

    span {
      font-weight: 500;
      font-size: 12px;
    }
  }

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
</style>
