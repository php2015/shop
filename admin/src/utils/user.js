import ls from '@/utils/storage'
import Cookies from 'js-cookie'

export function getToken () {
  return Cookies.get('token')
}

export function setToken (token) {
  return Cookies.set('token', token)
}

export function removeToken () {
  return Cookies.remove('token')
}

export function getRealName () {
  return ls.get('realname')
}

export function setRealName (name) {
  return ls.set('realname', name)
}

export function getUserName () {
  return ls.get('username')
}

export function setUserName (userName) {
  return ls.set('username', userName)
}

export function getAvatar () {
  return ls.get('avatar')
}

export function setAvatar (avatar) {
  return ls.set('avatar', avatar)
}

export function getMenu () {
  return ls.get('menu')
}

export function setMenu (avatar) {
  return ls.set('menu', avatar)
}
