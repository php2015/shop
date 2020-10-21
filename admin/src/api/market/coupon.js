import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'coupon',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'coupon/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'coupon/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'coupon/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'coupon/edit.do',
    method: 'post',
    data
  })
}

export function doStatus (id) {
  return request({
    url: 'coupon/status.do',
    method: 'post',
    data: {
      id: id
    }
  })
}

export function doIssue (data) {
  return request({
    url: 'coupon/issue.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'coupon/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
