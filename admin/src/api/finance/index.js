import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'payment',
    method: 'get',
    params: data
  })
}
