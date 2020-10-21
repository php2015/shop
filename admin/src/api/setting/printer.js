import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'printer',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'printer/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'printer/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'printer/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'printer/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'printer/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}

export function doStatus (id, field) {
  return request({
    url: 'printer/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}
