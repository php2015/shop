import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'logistics/template/express',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'logistics/template/express/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'logistics/template/express/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'logistics/template/express/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'logistics/template/express/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'logistics/template/express/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
