import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'user',
    method: 'get',
    params: data
  })
}

