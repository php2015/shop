import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'shop/page',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'shop/page/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function add () {
  return request({
    url: 'shop/page/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'shop/page/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'shop/page/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'shop/page/edit.do',
    method: 'post',
    data
  })
}

export function design (id) {
  return request({
    url: 'shop/page/design',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doDesign (data) {
  return request({
    url: 'shop/page/design.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'shop/page/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
