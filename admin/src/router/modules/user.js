import Layout from '@/layout'

const routes = [
  {
    path: 'user',
    component: Layout,
    redirect: '/user',
    meta: { title: '客户' },
    children: [
      // 客户
      {
        path: '/user',
        name: 'User',
        meta: { title: '资料' },
        component: () => import('@/views/user/index')
      }, {
        path: '/user/detail',
        name: 'UserDetail',
        meta: { title: '资料详情' },
        component: () => import('@/views/user/index/detail'),
        children: [
          {
            path: ':id',
            name: 'UserDetailIndex',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/index')
          }, {
            path: 'cart/:id',
            name: 'UserDetailCart',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/cart')
          }, {
            path: 'like/:id',
            name: 'UserDetailLike',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/like')
          }, {
            path: 'order/:id',
            name: 'UserDetailOrder',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/order')
          }, {
            path: 'points/:id',
            name: 'UserDetailPoints',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/points')
          }, {
            path: 'bonus/:id',
            name: 'UserDetailBonus',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/bonus')
          }, {
            path: 'coupon/:id',
            name: 'UserDetailCoupon',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/detail/coupon')
          }
        ]
      }, {
        path: '/user/edit',
        name: 'UserEdit',
        meta: { title: '编辑资料' },
        component: () => import('@/views/user/index/edit'),
        children: [
          {
            path: ':id',
            name: 'UserEditTag',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/edit/tag')
          }, {
            path: 'points/:id',
            name: 'UserEditPoints',
            meta: { active: '/user' },
            component: () => import('@/views/user/index/children/edit/points')
          }
        ]
      },
      // 单位
      {
        path: '/user/tag',
        name: 'UserTag',
        meta: { title: '标签' },
        component: () => import('@/views/user/tag')
      }, {
        path: '/user/tag/add',
        name: 'UserTagAdd',
        meta: { title: '添加标签', active: '/user/tag' },
        component: () => import('@/views/user/tag/add')
      }, {
        path: '/user/tag/edit/:id',
        name: 'UserTagEdit',
        meta: { title: '编辑标签', active: '/user/tag' },
        component: () => import('@/views/user/tag/edit')
      },
      // 用户反馈
      {
        path: '/user/feedback',
        name: 'UserFeedback',
        meta: { title: '反馈' },
        component: () => import('@/views/user/feedback/index')
      }
    ]
  }
]

export default routes
