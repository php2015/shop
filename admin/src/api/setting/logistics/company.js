import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'logistics/company',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'logistics/company/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'logistics/company/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'logistics/company/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'logistics/company/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'logistics/company/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
