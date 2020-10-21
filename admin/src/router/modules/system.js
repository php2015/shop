import Layout from '@/layout'

const routes = [
  {
    path: 'system',
    component: Layout,
    redirect: '/system/admin',
    meta: { title: '系统' },
    children: [
      // 账号
      {
        path: '/system/admin',
        name: 'Admin',
        meta: { title: '账号' },
        component: () => import('@/views/system/admin/index')
      },
      {
        path: '/system/admin/add',
        name: 'AdminAdd',
        meta: { title: '添加账号', active: '/system/admin' },
        component: () => import('@/views/system/admin/add')
      },
      {
        path: '/system/admin/edit/:id',
        name: 'AdminEdit',
        meta: { title: '编辑账号', active: '/system/admin' },
        component: () => import('@/views/system/admin/edit')
      },
      // 模块
      {
        path: '/system/module',
        name: 'Module',
        meta: { title: '模块' },
        component: () => import('@/views/system/module/index')
      },
      {
        path: '/system/module/add/*',
        name: 'ModuleAdd',
        meta: { title: '添加模块', active: '/system/module' },
        component: () => import('@/views/system/module/add')
      },
      {
        path: '/system/module/edit/:id',
        name: 'ModuleEdit',
        meta: { title: '编辑模块', active: '/system/module' },
        component: () => import('@/views/system/module/edit')
      },
      {
        path: '/system/module/sort/*',
        name: 'ModuleSort',
        meta: { title: '排序模块', active: '/system/module' },
        component: () => import('@/views/system/module/sort')
      },
      // 角色
      {
        path: '/system/role',
        name: 'Role',
        meta: { title: '角色' },
        component: () => import('@/views/system/role/index')
      },
      {
        path: '/system/role/add',
        name: 'RoleAdd',
        meta: { title: '添加角色', active: '/system/role' },
        component: () => import('@/views/system/role/add')
      },
      {
        path: '/system/role/edit/:id',
        name: 'RoleEdit',
        meta: { title: '编辑角色', active: '/system/role' },
        component: () => import('@/views/system/role/edit')
      },
      // 日志
      {
        path: '/system/log',
        name: 'Log',
        meta: { title: '日志' },
        component: () => import('@/views/system/log/index')
      }
    ]
  }
]

export default routes
