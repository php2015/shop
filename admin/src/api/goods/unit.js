import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'goods/unit',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'goods/unit/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'goods/unit/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'goods/unit/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'goods/unit/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'goods/unit/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
