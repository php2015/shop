import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'finance/cash',
    method: 'get',
    params: data
  })
}

export function audit (id) {
  return request({
    url: 'finance/cash/audit',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doAudit (data) {
  return request({
    url: 'finance/cash/audit.do',
    method: 'post',
    data
  })
}
