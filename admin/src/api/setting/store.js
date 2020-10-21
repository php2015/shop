import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'store',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'store/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'store/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'store/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'store/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'store/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
