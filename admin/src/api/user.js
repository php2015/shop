import request from '@/utils/request'

export function login (data) {
  return request({
    url: 'auth',
    method: 'post',
    data
  })
}

export function logout () {
  return request({
    url: 'auth/logout',
    method: 'post'
  })
}
