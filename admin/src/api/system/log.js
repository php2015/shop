import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'log',
    method: 'get',
    params: data
  })
}

export function detail (id) {
  return request({
    url: 'log/detail',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doRemove (id) {
  return request({
    url: 'log/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
