import request from '@/utils/request'

export function info () {
  return request({
    url: 'profile',
    method: 'get'
  })
}

export function setInfo (data) {
  return request({
    url: 'profile/info',
    method: 'post',
    data
  })
}

export function password (data) {
  return request({
    url: 'profile/password',
    method: 'post',
    data
  })
}
