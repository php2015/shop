import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'module',
    method: 'get',
    params: data
  })
}

export function add () {
  return request({
    url: 'module/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'module/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'module/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'module/edit.do',
    method: 'post',
    data
  })
}

export function sort (id) {
  return request({
    url: 'module/sort',
    method: 'get',
    params: {
      parent_id: id
    }
  })
}

export function doSort (id) {
  return request({
    url: 'module/sort.do',
    method: 'post',
    data: {
      id: id
    }
  })
}

export function doRemove (id) {
  return request({
    url: 'module/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
