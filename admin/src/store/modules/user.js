import { login, logout } from '@/api/user'
import {
  getToken,
  setToken,
  removeToken,
  getRealName,
  setRealName,
  getUserName,
  setUserName,
  getAvatar,
  setAvatar,
  getMenu,
  setMenu
} from '@/utils/user'
import { resetRouter } from '@/router'

const state = {
  token: getToken(),
  username: getUserName(),
  realname: getRealName(),
  avatar: getAvatar(),
  menu: getMenu()
}

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  REMOVE_TOKEN: (state) => {
    state.token = ''
  },
  SET_USERNAME: (state, username) => {
    state.username = username
  },
  SET_REALNAME: (state, realname) => {
    state.realname = realname
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar
  },
  SET_MENU: (state, menu) => {
    state.menu = menu
  }
}

const actions = {
  login ({ commit }, userInfo) {
    const { username, password } = userInfo
    return new Promise((resolve, reject) => {
      login({ username: username.trim(), password: password }).then(res => {
        const { data } = res

        commit('SET_TOKEN', data.token)
        setToken(data.token)
        commit('SET_USERNAME', data.username)
        setUserName(data.username)
        commit('SET_REALNAME', data.realname)
        setRealName(data.realname)
        commit('SET_AVATAR', data.avatar)
        setAvatar(data.avatar)
        commit('SET_MENU', JSON.stringify(data.menu))
        setMenu(data.menu)
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  logout ({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout().then((res) => {
        commit('SET_TOKEN', '')
        removeToken()
        setRealName('')
        setAvatar('')
        setMenu('')
        resetRouter()
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  resetToken ({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '')
      removeToken()
      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

