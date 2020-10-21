import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'article/category',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'article/category/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function add () {
  return request({
    url: 'article/category/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'article/category/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'article/category/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'article/category/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'article/category/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
