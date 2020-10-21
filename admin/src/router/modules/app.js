import Layout from '@/layout'

const routes = [
  {
    path: '/login',
    component: () => import('@/views/login')
  },

  {
    path: '/404',
    component: () => import('@/views/404')
  },

  {
    path: '/403',
    component: () => import('@/views/403')
  },

  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: () => import('@/views/dashboard/index'),
        meta: { title: '仪表盘' }
      }
    ]
  },

  {
    path: 'profile',
    component: Layout,
    meta: { title: '个人设置' },
    children: [
      {
        path: '/profile',
        component: () => import('@/views/profile'),
        children: [
          {
            path: '',
            name: 'Profile',
            meta: { title: '基本信息' },
            component: () => import('@/views/profile/children/index')
          }, {
            path: 'password',
            name: 'ProfilePassword',
            meta: { title: '修改密码' },
            component: () => import('@/views/profile/children/password')
          }
        ]
      }
    ]
  }
]

export default routes
