import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'order/invoice',
    method: 'get',
    params: data
  })
}

export function issue (id) {
  return request({
    url: 'order/invoice/issue',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doIssue (data) {
  return request({
    url: 'order/invoice/issue.do',
    method: 'post',
    data
  })
}
