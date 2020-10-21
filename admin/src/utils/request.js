import axios from 'axios'
import { MessageBox, Message } from 'element-ui'
import store from '@/store'
import getSign from '@/utils/sign'
import router from '@/router'
import { getToken } from '@/utils/user'

const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API,
  timeout: 6000
})

service.interceptors.request.use(
  config => {
    if (store.getters.token) {
      config.headers['X-Token'] = getToken()
    }

    config.data = config.data || {}
    config.params = config.params || {}
    config.params.timestamp = new Date().getTime()
    config.headers['X-Sign'] = getSign(config.url, Object.assign(config.data, config.params))
    return config
  },
  error => {
    return Promise.reject(error)
  }
)

service.interceptors.response.use(
  response => {
    const res = response.data

    if (res.code > 0) {
      Message({
        message: res.msg || 'Error',
        type: 'error',
        duration: 5 * 1000
      })
      return Promise.reject(res)
    }
    return Promise.resolve(res)
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        // 登录过期
        case 401:
          MessageBox.confirm('您的登录已过期，您可以点击取消按钮继续留在该页面，或者重新登录。', '系统提示', {
            confirmButtonText: '去登录',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(() => {
            store.dispatch('user/resetToken').then(() => {
              location.reload()
            })
          })
          break
        // 无权访问
        case 403:
          router.push('/403')
          break
        case 500:
          console.error('系统错误:', error.response)
          break
      }
      return Promise.reject(error.response.data)
    }

    MessageBox.alert('请求超时，请点击按钮刷新当前页面。', '系统提示', {
      confirmButtonText: '刷新页面',
      type: 'warning'
    }).then(() => {
      location.reload()
    })
  }
)

export default service
