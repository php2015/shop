import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'market/coupon',
    method: 'get',
    params: data
  })
}

export function doStatus (id, field) {
  return request({
    url: 'market/coupon/status.do',
    method: 'post',
    data: {
      id: id,
      field: field
    }
  })
}

export function add () {
  return request({
    url: 'market/coupon/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'market/coupon/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'market/coupon/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'market/coupon/edit.do',
    method: 'post',
    data
  })
}

export function doIssue (data) {
  return request({
    url: 'market/coupon/issue.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'market/coupon/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
