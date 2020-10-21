import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'role',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'role/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'role/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'role/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'role/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'role/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
