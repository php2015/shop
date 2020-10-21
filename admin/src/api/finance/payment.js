import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'finance/payment',
    method: 'get',
    params: data
  })
}
