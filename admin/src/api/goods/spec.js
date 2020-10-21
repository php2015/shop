import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'goods/spec',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'goods/spec/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'goods/spec/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'goods/spec/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'goods/spec/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'goods/spec/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}

export function doAddValue (data) {
  return request({
    url: 'goods/spec/value/add.do',
    method: 'post',
    data
  })
}

export function doRemoveValue (id) {
  return request({
    url: 'goods/spec/value/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
