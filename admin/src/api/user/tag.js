import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'user/tag',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'user/tag/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'user/tag/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'user/tag/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'user/tag/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'user/tag/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
