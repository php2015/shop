import request from '@/utils/request'

export function get (params) {
  return request({
    url: 'setting',
    method: 'get',
    params: {
      params: params
    }
  })
}

export function save (params, data) {
  return request({
    url: 'setting/save',
    method: 'post',
    data: {
      params: params,
      values: JSON.stringify(data)
    }
  })
}

export function doFlush (key) {
  return request({
    url: 'setting/flush',
    method: 'post',
    data: {
      key: key
    }
  })
}
