import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'coupon/receive',
    method: 'get',
    params: data
  })
}

export function doRemove (id) {
  return request({
    url: 'coupon/receive/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
