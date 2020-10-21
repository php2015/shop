import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import ls from '@/utils/storage'

import 'element-ui/lib/theme-chalk/index.css'
import ElementUI from 'element-ui'
Vue.use(ElementUI, {
  size: ls.get('size') || 'medium'
})

import 'normalize.css/normalize.css'
import '@/styles/index.scss'
import '@/icons'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
