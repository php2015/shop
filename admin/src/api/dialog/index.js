import request from '@/utils/request'

export function user (data) {
  return request({
    url: 'dialog/user',
    method: 'get',
    params: data
  })
}

export function coupon (data) {
  return request({
    url: 'dialog/coupon',
    method: 'get',
    params: data
  })
}

export function goods (data) {
  return request({
    url: 'dialog/goods',
    method: 'get',
    params: data
  })
}
