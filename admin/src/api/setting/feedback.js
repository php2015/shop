import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'feedback/category',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'feedback/category/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'feedback/category/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'feedback/category/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'feedback/category/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'feedback/category/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
