import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'market/coupon/receive',
    method: 'get',
    params: data
  })
}

export function doRemove (id) {
  return request({
    url: 'market/coupon/receive/remove.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
