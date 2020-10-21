import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'shop/employee',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'shop/employee/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function add () {
  return request({
    url: 'shop/employee/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'shop/employee/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'shop/employee/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'shop/employee/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'shop/employee/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
