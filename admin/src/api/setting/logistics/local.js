import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'logistics/template/local',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'logistics/template/local/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'logistics/template/local/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'logistics/template/local/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'logistics/template/local/edit.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'logistics/template/local/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
