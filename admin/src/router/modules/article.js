import Layout from '@/layout'

const routes = [
  {
    path: 'article',
    redirect: '/article',
    meta: { title: '文章' },
    component: Layout,
    children: [
      // 文章
      {
        path: '/article',
        name: 'Article',
        meta: { title: '列表' },
        component: () => import('@/views/article/index')
      }, {
        path: '/article/index/add',
        name: 'ArticleAdd',
        meta: { title: '添加文章', active: '/article' },
        component: () => import('@/views/article/index/add')
      }, {
        path: '/article/index/edit/:id',
        name: 'ArticleEdit',
        meta: { title: '编辑文章', active: '/article' },
        component: () => import('@/views/article/index/edit')
      },
      // 分类
      {
        path: '/article/category',
        name: 'ArticleCategory',
        meta: { title: '分类' },
        component: () => import('@/views/article/category/index')
      }, {
        path: '/article/category/add',
        name: 'ArticleCategoryAdd',
        meta: { title: '添加分类', active: '/article/category' },
        component: () => import('@/views/article/category/add')
      }, {
        path: '/article/category/edit/:id',
        name: 'ArticleCategoryEdit',
        meta: { title: '编辑分类', active: '/article/category' },
        component: () => import('@/views/article/category/edit')
      },
      // 横幅
      {
        path: '/article/banner',
        name: 'ArticleBanner',
        meta: { title: '横幅' },
        component: () => import('@/views/article/banner/index')
      }, {
        path: '/article/banner/add',
        name: 'ArticleBannerAdd',
        meta: { title: '添加横幅', active: '/article/banner' },
        component: () => import('@/views/article/banner/add')
      }, {
        path: '/article/banner/edit/:id',
        name: 'ArticleBannerEdit',
        meta: { title: '编辑横幅', active: '/article/banner' },
        component: () => import('@/views/article/banner/edit')
      }
    ]
  }
]

export default routes
