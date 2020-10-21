import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'market/distribution',
    method: 'get',
    params: data
  })
}

export function auth (id) {
  return request({
    url: 'market/distribution/auth',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doAuth (data) {
  return request({
    url: 'market/distribution/auth.do',
    method: 'post',
    data
  })
}
