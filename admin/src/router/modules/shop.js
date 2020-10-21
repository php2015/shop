import Layout from '@/layout'

const routes = [
  {
    path: 'shop',
    component: Layout,
    redirect: '/shop/design',
    meta: { title: '店铺' },
    children: [
      // 装修
      {
        path: '/shop/design',
        name: 'ShopDesign',
        meta: { title: '装修' },
        component: () => import('@/views/shop/design')
      },
      // 页面
      {
        path: '/shop/page',
        name: 'ShopPage',
        meta: { title: '页面' },
        component: () => import('@/views/shop/page')
      }, {
        path: '/shop/page/add',
        name: 'ShopPageAdd',
        meta: { title: '添加页面', active: '/shop/page' },
        component: () => import('@/views/shop/page/add')
      }, {
        path: '/shop/page/edit/:id',
        name: 'ShopPageEdit',
        meta: { title: '编辑页面', active: '/shop/page' },
        component: () => import('@/views/shop/page/edit')
      }, {
        path: '/shop/page/design/:id',
        name: 'ShopPageDesign',
        meta: { title: '设计页面', active: '/shop/page' },
        component: () => import('@/views/shop/page/design')
      },
      // 店铺
      {
        path: '/shop/store',
        name: 'ShopStore',
        meta: { title: '门店' },
        component: () => import('@/views/shop/store')
      }, {
        path: '/shop/store/add',
        name: 'ShopStoreAdd',
        meta: { title: '添加门店', active: '/shop/store' },
        component: () => import('@/views/shop/store/add')
      }, {
        path: '/shop/store/edit/:id',
        name: 'ShopStoreEdit',
        meta: { title: '编辑门店', active: '/shop/store' },
        component: () => import('@/views/shop/store/edit')
      },
      // 地址库
      {
        path: '/shop/address',
        name: 'ShopAddress',
        meta: { title: '自提点' },
        component: () => import('@/views/shop/address')
      }, {
        path: '/shop/address/add',
        name: 'ShopAddressAdd',
        meta: { title: '添加自提点', active: '/shop/address' },
        component: () => import('@/views/shop/address/add')
      }, {
        path: '/shop/address/edit/:id',
        name: 'ShopAddressEdit',
        meta: { title: '编辑自提点', active: '/shop/address' },
        component: () => import('@/views/shop/address/edit')
      },
      // 员工
      {
        path: '/shop/employee',
        name: 'ShopEmploy',
        meta: { title: '员工' },
        component: () => import('@/views/shop/employee')
      }, {
        path: '/shop/employee/add',
        name: 'ShopEmployAdd',
        meta: { title: '添加员工', active: '/shop/employee' },
        component: () => import('@/views/shop/employee/add')
      }, {
        path: '/shop/employee/edit/:id',
        name: 'ShopEmployeeEdit',
        meta: { title: '编辑员工', active: '/shop/employee' },
        component: () => import('@/views/shop/employee/edit')
      }
    ]
  }
]

export default routes
