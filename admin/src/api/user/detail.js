import request from '@/utils/request'

export function detail (id) {
  return request({
    url: 'user/detail',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function cart (data) {
  return request({
    url: 'user/detail/cart',
    method: 'get',
    params: data
  })
}

export function like (data) {
  return request({
    url: 'user/detail/like',
    method: 'get',
    params: data
  })
}

export function order (data) {
  return request({
    url: 'user/detail/order',
    method: 'get',
    params: data
  })
}

export function coupon (data) {
  return request({
    url: 'user/detail/coupon',
    method: 'get',
    params: data
  })
}

export function points (data) {
  return request({
    url: 'user/detail/points',
    method: 'get',
    params: data
  })
}

export function bonus (data) {
  return request({
    url: 'user/detail/bonus',
    method: 'get',
    params: data
  })
}
