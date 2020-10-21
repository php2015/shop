import Layout from '@/layout'

const routes = [
  {
    path: 'finance',
    redirect: '/finance/payment',
    meta: { title: '财务' },
    component: Layout,
    children: [
      // 支付流水
      {
        path: '/finance/payment',
        name: 'FinancePayment',
        meta: { title: '支付流水' },
        component: () => import('@/views/finance/payment')
      },
      // 提现记录
      {
        path: '/finance/cash',
        name: 'FinanceCash',
        meta: { title: '提现记录' },
        component: () => import('@/views/finance/cash/index')
      },
      {
        path: '/finance/cash/audit/:id',
        name: 'FinanceCashAudit',
        meta: { title: '提现审核', active: '/finance/cash' },
        component: () => import('@/views/finance/cash/audit')
      }
    ]
  }
]

export default routes
