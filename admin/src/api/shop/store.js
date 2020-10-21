import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'shop/store',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'shop/store/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function add () {
  return request({
    url: 'shop/store/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'shop/store/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'shop/store/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'shop/store/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'shop/store/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
