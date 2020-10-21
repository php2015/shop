import request from '@/utils/request'

export function init (data) {
  return request({
    url: 'user/feedback',
    method: 'get',
    params: data
  })
}

export function list (data) {
  return request({
    url: 'user/feedback/list',
    method: 'get',
    params: data
  })
}

export function doRemove (id) {
  return request({
    url: 'user/feedback/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
