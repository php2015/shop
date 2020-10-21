import Layout from '@/layout'

const routes = [
  {
    path: 'market',
    component: Layout,
    redirect: '/market/coupon',
    meta: { title: '营销' },
    children: [
      // 优惠卷
      {
        path: '/market/coupon',
        name: 'MarketCoupon',
        meta: { title: '优惠卷' },
        component: () => import('@/views/market/coupon/index')
      }, {
        path: '/market/coupon/add',
        name: 'MarketCouponAdd',
        meta: { title: '添加优惠卷', active: '/market/coupon' },
        component: () => import('@/views/market/coupon/index/add')
      }, {
        path: '/market/coupon/edit/:id',
        name: 'MarketCouponEdit',
        meta: { title: '编辑优惠卷', active: '/market/coupon' },
        component: () => import('@/views/market/coupon/index/edit')
      }, {
        path: '/market/coupon/issue',
        name: 'MarketCouponIssue',
        meta: { title: '发放优惠卷', active: '/market/coupon' },
        component: () => import('@/views/market/coupon/index/issue')
      },
      // 优惠卷领取
      {
        path: '/market/coupon/receive',
        name: 'MarketCouponReceive',
        meta: { title: '优惠卷领取' },
        component: () => import('@/views/market/coupon/receive')
      },
      // 分销商
      {
        path: '/market/distribution',
        name: 'MarketDistribution',
        meta: { title: '分销商' },
        component: () => import('@/views/market/distribution')
      }, {
        path: '/market/distribution/auth/:id',
        name: 'MarketDistributionAuth',
        meta: { title: '分销商审核' },
        component: () => import('@/views/market/distribution/auth')
      }
    ]
  }
]

export default routes
