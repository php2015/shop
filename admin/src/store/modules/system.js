import ls from '@/utils/storage'
import { index } from '@/api/system'

const state = {
  name: ls.get('system_name'),
  copyright: ls.get('copyright'),
  logo: ls.get('logo')
}

const mutations = {
  SET_NAME: (state, value) => {
    state.name = value
    ls.set('system_name', value)
  },
  SET_COPYRIGHT: (state, value) => {
    state.copyright = value
    ls.set('copyright', value)
  },
  SET_LOGO: (state, value) => {
    state.logo = value
    ls.set('logo', value)
  }
}

const actions = {
  info ({ commit }) {
    return new Promise((resolve, reject) => {
      index().then((res) => {
        commit('SET_NAME', res.data.system_name)
        commit('SET_COPYRIGHT', res.data.copyright)
        commit('SET_LOGO', res.data.logo)
        resolve(res)
      }).catch(error => {
        reject(error)
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
