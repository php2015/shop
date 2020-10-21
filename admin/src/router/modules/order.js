import Layout from '@/layout'

const routes = [
  {
    path: 'order',
    component: Layout,
    redirect: '/order',
    meta: { title: '订单' },
    children: [
      {
        path: '/order',
        redirect: '/order',
        component: () => import('@/views/order/index'),
        children: [
          {
            path: '',
            name: 'OrderAll',
            meta: { title: '全部订单', active: '/order' },
            component: () => import('@/views/order/index/children/index')
          }, {
            path: 'express',
            name: 'OrderExpress',
            meta: { title: '快递发货', active: '/order' },
            component: () => import('@/views/order/index/children/express')
          }, {
            path: 'local',
            name: 'OrderLocal',
            meta: { title: '同城配送', active: '/order' },
            component: () => import('@/views/order/index/children/local')
          }, {
            path: 'fetch',
            name: 'OrderFetch',
            meta: { title: '上门自提', active: '/order' },
            component: () => import('@/views/order/index/children/fetch')
          }
        ]
      }, {
        path: '/order/detail/:id',
        name: 'OrderDetail',
        meta: { title: '订单详细', active: '/order' },
        component: () => import('@/views/order/index/detail')
      }, {
        path: '/order/shipment/:id',
        name: 'OrderShipment',
        meta: { title: '订单发货', active: '/order' },
        component: () => import('@/views/order/index/shipment')
      },
      // 发票
      {
        path: '/order/invoice',
        name: 'OrderInvoice',
        meta: { title: '发票' },
        component: () => import('@/views/order/invoice')
      }, {
        path: '/order/invoice/issue/:id',
        name: 'OrderInvoiceIssue',
        meta: { title: '开票', active: '/order/invoice' },
        component: () => import('@/views/order/invoice/issue')
      },
      // 评论
      {
        path: '/order/comment',
        name: 'OrderComment',
        meta: { title: '评论' },
        component: () => import('@/views/order/comment')
      }, {
        path: '/order/comment/reply/:id',
        name: 'OrderCommentReply',
        meta: { title: '评论回复', active: '/order/comment' },
        component: () => import('@/views/order/comment/reply')
      }
    ]
  }
]

export default routes
