import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'goods/support',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'goods/support/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'goods/support/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'goods/support/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'goods/support/edit.do',
    method: 'post',
    data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'goods/support/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function doRemove (id) {
  return request({
    url: 'goods/support/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
