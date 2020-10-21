import Layout from '@/layout'

const routes = [
  {
    path: 'goods',
    component: Layout,
    redirect: '/goods',
    meta: { title: '商品' },
    children: [
      // 商品
      {
        path: '/goods',
        meta: { title: '列表' },
        component: () => import('@/views/goods/index'),
        children: [
          {
            path: '',
            name: 'GoodsSales',
            meta: { title: '销售中', active: '/goods' },
            component: () => import('@/views/goods/index/children/index')
          }, {
            path: 'stock',
            name: 'GoodsStock',
            meta: { title: '仓库中', active: '/goods' },
            component: () => import('@/views/goods/index/children/stock')
          }, {
            path: 'sold',
            name: 'GoodsSold',
            meta: { title: '已售罄', active: '/goods' },
            component: () => import('@/views/goods/index/children/sold')
          }
        ]
      }, {
        path: '/goods/add',
        name: 'GoodsAdd',
        meta: { title: '添加商品', active: '/goods' },
        component: () => import('@/views/goods/index/add')
      }, {
        path: '/goods/edit/:id',
        name: 'GoodsEdit',
        meta: { title: '编辑商品', active: '/goods' },
        component: () => import('@/views/goods/index/edit')
      },
      // 分类
      {
        path: '/goods/category',
        name: 'GoodsCategory',
        meta: { title: '分类' },
        component: () => import('@/views/goods/category')
      }, {
        path: '/goods/category/add/*',
        name: 'GoodsCategoryAdd',
        meta: { title: '添加分类', active: '/goods/category' },
        component: () => import('@/views/goods/category/add')
      }, {
        path: '/goods/category/edit/:id',
        name: 'GoodsCategoryEdit',
        meta: { title: '编辑分类', active: '/goods/category' },
        component: () => import('@/views/goods/category/edit')
      }, {
        path: '/goods/category/sort/*',
        name: 'GoodsCategorySort',
        meta: { title: '排序分类', active: '/goods/category' },
        component: () => import('@/views/goods/category/sort')
      },
      // 分组
      {
        path: '/goods/group',
        name: 'GoodsGroup',
        meta: { title: '分组' },
        component: () => import('@/views/goods/group')
      }, {
        path: '/goods/group/add',
        name: 'GoodsGroupAdd',
        meta: { title: '添加分组', active: '/goods/group' },
        component: () => import('@/views/goods/group/add')
      }, {
        path: '/goods/group/edit/:id',
        name: 'GoodsGroupEdit',
        meta: { title: '编辑分组', active: '/goods/group' },
        component: () => import('@/views/goods/group/edit')
      },
      // 规格
      {
        path: '/goods/spec',
        name: 'GoodsSpec',
        meta: { title: '规格' },
        component: () => import('@/views/goods/spec')
      }, {
        path: '/goods/spec/add',
        name: 'GoodsSpecAdd',
        meta: { title: '添加规格', active: '/goods/spec' },
        component: () => import('@/views/goods/spec/add')
      }, {
        path: '/goods/spec/edit/:id',
        name: 'GoodsSpecEdit',
        meta: { title: '编辑规格', active: '/goods/spec' },
        component: () => import('@/views/goods/spec/edit')
      },
      // 支持
      {
        path: '/goods/support',
        name: 'GoodsSupport',
        meta: { title: '支持' },
        component: () => import('@/views/goods/support')
      }, {
        path: '/goods/support/add',
        name: 'GoodsSupportAdd',
        meta: { title: '添加支持', active: '/goods/support' },
        component: () => import('@/views/goods/support/add')
      }, {
        path: '/goods/support/edit/:id',
        name: 'GoodsSupportEdit',
        meta: { title: '编辑支持', active: '/goods/support' },
        component: () => import('@/views/goods/support/edit')
      },
      // 单位
      {
        path: '/goods/unit',
        name: 'GoodsUnit',
        meta: { title: '单位' },
        component: () => import('@/views/goods/unit')
      }, {
        path: '/goods/unit/add',
        name: 'GoodsUnitAdd',
        meta: { title: '添加单位', active: '/goods/unit' },
        component: () => import('@/views/goods/unit/add')
      }, {
        path: '/goods/unit/edit/:id',
        name: 'GoodsUnitEdit',
        meta: { title: '编辑单位', active: '/goods/unit' },
        component: () => import('@/views/goods/unit/edit')
      }
    ]
  }
]

export default routes
