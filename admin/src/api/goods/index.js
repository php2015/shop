import request from '@/utils/request'

export function index () {
  return request({
    url: 'goods'
  })
}

export function list (data) {
  return request({
    url: 'goods/list',
    method: 'get',
    params: data
  })
}

export function doStatus (id, value) {
  return request({
    url: 'goods/status.do',
    method: 'post',
    data: {
      id: id,
      value: value
    }
  })
}

export function add () {
  return request({
    url: 'goods/add',
    method: 'get'
  })
}

export function doAdd (data) {
  return request({
    url: 'goods/add.do',
    method: 'post',
    data
  })
}

export function edit (id) {
  return request({
    url: 'goods/edit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doEdit (data) {
  return request({
    url: 'goods/edit.do',
    method: 'post',
    data
  })
}

export function content (id) {
  return request({
    url: 'goods/content',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doContent (data) {
  return request({
    url: 'goods/content.do',
    method: 'post',
    data
  })
}

export function sale (id) {
  return request({
    url: 'goods/sale',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doSale (data) {
  return request({
    url: 'goods/sale.do',
    method: 'post',
    data
  })
}

export function logistics (id) {
  return request({
    url: 'goods/logistics',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doLogistics (data) {
  return request({
    url: 'goods/logistics.do',
    method: 'post',
    data
  })
}

export function other (id) {
  return request({
    url: 'goods/other',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doOther (data) {
  return request({
    url: 'goods/other.do',
    method: 'post',
    data
  })
}

export function doRemove (id) {
  return request({
    url: 'goods/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
