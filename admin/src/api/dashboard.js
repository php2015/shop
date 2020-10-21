import request from '@/utils/request'

export function index () {
  return request({
    url: 'index',
    method: 'get'
  })
}

export function market (date) {
  return request({
    url: 'index/market',
    method: 'get',
    params: {
      date: date
    }
  })
}

export function order () {
  return request({
    url: 'index/order'
  })
}

export function distribution () {
  return request({
    url: 'index/distribution'
  })
}

export function cash () {
  return request({
    url: 'index/cash'
  })
}

export function goods (date) {
  return request({
    url: 'index/goods',
    method: 'get',
    params: {
      date: date
    }
  })
}
