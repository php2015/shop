import Layout from '@/layout'

const routes = [
  {
    path: 'setting',
    component: Layout,
    redirect: '/setting/system',
    meta: { title: '设置' },
    children: [
      // 系统
      {
        path: '/setting/system',
        meta: { title: '系统' },
        component: () => import('@/views/setting/system/index'),
        children: [
          {
            path: '',
            name: 'SettingSystemIndex',
            meta: { title: '基础设置', active: '/setting/system' },
            component: () => import('@/views/setting/system/children/index')
          }, {
            path: 'security',
            name: 'SettingSystemSecurity',
            meta: { title: '安全设置', active: '/setting/system' },
            component: () => import('@/views/setting/system/children/security')
          }, {
            path: 'cache',
            name: 'SettingSystemCache',
            meta: { title: '存储设置', active: '/setting/system' },
            component: () => import('@/views/setting/system/children/cache')
          }, {
            path: 'storage',
            name: 'SettingSystemStorage',
            meta: { title: '缓存设置', active: '/setting/system' },
            component: () => import('@/views/setting/system/children/storage')
          }
        ]
      },
      // 微信
      {
        path: '/setting/wechat',
        meta: { title: '微信' },
        component: () => import('@/views/setting/wechat/index'),
        children: [
          {
            path: '',
            name: 'SettingWechatIndex',
            meta: { title: '公众号设置', active: '/setting/wechat' },
            component: () => import('@/views/setting/wechat/children/index')
          }, {
            path: 'wxapp',
            name: 'SettingWechatWxapp',
            meta: { title: '小程序设置', active: '/setting/wechat' },
            component: () => import('@/views/setting/wechat/children/wxapp')
          }, {
            path: 'payment',
            name: 'SettingWechatPayment',
            meta: { title: '支付设置', active: '/setting/wechat' },
            component: () => import('@/views/setting/wechat/children/payment')
          }, {
            path: 'location',
            name: 'SettingWechatLocation',
            meta: { title: '腾讯位置服务', active: '/setting/wechat' },
            component: () => import('@/views/setting/wechat/children/location')
          }
        ]
      },
      // 消息
      {
        path: '/setting/message',
        meta: { title: '消息' },
        component: () => import('@/views/setting/message/index'),
        children: [
          {
            path: '',
            name: 'SettingMessageSms',
            meta: { title: '短信', active: '/setting/message' },
            component: () => import('@/views/setting/message/children/sms')
          }, {
            path: 'wx',
            name: 'SettingMessageWx',
            meta: { title: '公众号模板消息', active: '/setting/message' },
            component: () => import('@/views/setting/message/children/wx')
          }, {
            path: 'wxapp',
            name: 'SettingMessageWxapp',
            meta: { title: '小程序模板消息', active: '/setting/message' },
            component: () => import('@/views/setting/message/children/wxapp')
          }
        ]
      },
      // 打印
      {
        path: '/setting/prints',
        meta: { title: '打印' },
        component: () => import('@/views/setting/prints/index'),
        children: [
          {
            path: '',
            name: 'SettingPrintsIndex',
            meta: { title: '基础设置', active: '/setting/prints' },
            component: () => import('@/views/setting/prints/children/index')
          }, {
            path: 'printer',
            name: 'SettingPrintsPrinter',
            meta: { title: '打印机设置', active: '/setting/prints' },
            component: () => import('@/views/setting/prints/children/printer')
          }
        ]
      },
      // 财务
      {
        path: '/setting/finance',
        meta: { title: '财务' },
        component: () => import('@/views/setting/finance/index'),
        children: [
          {
            path: '',
            name: 'SettingFinanceCash',
            meta: { title: '提现设置', active: '/setting/finance' },
            component: () => import('@/views/setting/finance/children/cash')
          }, {
            path: 'deposit',
            name: 'SettingFinanceDeposit',
            meta: { title: '充值设置', active: '/setting/finance' },
            component: () => import('@/views/setting/finance/children/deposit')
          }
        ]
      },
      // 营销
      {
        path: '/setting/market',
        meta: { title: '营销' },
        component: () => import('@/views/setting/market/index'),
        children: [
          {
            path: '',
            name: 'SettingMarketIndex',
            meta: { title: '分销设置', active: '/setting/market' },
            component: () => import('@/views/setting/market/children/distribution')
          }, {
            path: 'invite',
            name: 'SettingMarketInvite',
            meta: { title: '邀请设置', active: '/setting/market' },
            component: () => import('@/views/setting/market/children/invite')
          }, {
            path: 'register',
            name: 'SettingMarketRegister',
            meta: { title: '邀请设置', active: '/setting/market' },
            component: () => import('@/views/setting/market/children/register')
          }
        ]
      },
      // 物流
      {
        path: '/setting/logistics',
        meta: { title: '物流' },
        component: () => import('@/views/setting/logistics/index'),
        children: [
          {
            path: '',
            name: 'SettingLogisticsIndex',
            meta: { title: '基础设置', active: '/setting/logistics' },
            component: () => import('@/views/setting/logistics/children/index')
          }, {
            path: 'free',
            name: 'SettingLogisticsFree',
            meta: { title: '包邮设置', active: '/setting/logistics/free' },
            component: () => import('@/views/setting/logistics/children/free')
          }, {
            path: 'company',
            name: 'SettingLogisticsCompany',
            meta: { title: '快递公司', active: '/setting/logistics' },
            component: () => import('@/views/setting/logistics/children/company')
          }, {
            path: 'express',
            name: 'SettingLogisticsExpress',
            meta: { title: '快递发货', active: '/setting/logistics' },
            component: () => import('@/views/setting/logistics/children/express')
          }, {
            path: 'local',
            name: 'SettingLogisticsLocal',
            meta: { title: '同城配送', active: '/setting/logistics' },
            component: () => import('@/views/setting/logistics/children/local')
          }
        ]
      },
      // APP
      {
        path: '/setting/app',
        meta: { title: '应用' },
        component: () => import('@/views/setting/app/index'),
        children: [
          {
            path: '',
            name: 'SettingAppIndex',
            meta: { title: '基础设置', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/index')
          }, {
            path: 'order',
            name: 'SettingAppOrder',
            meta: { title: '订单设置', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/order')
          }, {
            path: 'points',
            name: 'SettingAppPoints',
            meta: { title: '积分设置', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/points')
          }, {
            path: 'invite',
            name: 'SettingAppInvite',
            meta: { title: '邀请设置', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/invite')
          }, {
            path: 'feedback',
            name: 'SettingAppFeedback',
            meta: { title: '反馈分类', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/feedback')
          }, {
            path: 'rule',
            name: 'SettingAppRule',
            meta: { title: '规则协议', active: '/setting/app' },
            component: () => import('@/views/setting/app/children/rule')
          }
        ]
      }
    ]
  }
]

export default routes
