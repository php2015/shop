import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'goods/category',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'goods/category/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'goods/category/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'goods/category/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'goods/category/edit.do',
    method: 'post',
    data
  })
}

export function sort (id) {
  return request({
    url: 'goods/category/sort',
    method: 'get',
    params: {
      parent_id: id
    }
  })
}

export function doSort (id) {
  return request({
    url: 'goods/category/sort.do',
    method: 'post',
    data: {
      id: id
    }
  })
}

export function doStatus (id, field) {
  return request({
    url: 'goods/category/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function doRemove (id) {
  return request({
    url: 'goods/category/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
