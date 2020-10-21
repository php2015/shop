import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'rule',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'rule/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'rule/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'rule/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'rule/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'rule/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
