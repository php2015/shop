import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'admin',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'admin/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'admin/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'admin/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'admin/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'admin/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
