import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'order/comment',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'order/comment/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function doReply (data) {
  return request({
    url: 'order/comment/reply.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'order/comment/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
