import request from '@/utils/request'

export function tag (id) {
  return request({
    url: 'user/edit/tag',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doTag (data) {
  return request({
    url: 'user/edit/tag.do',
    method: 'post',
    data
  })
}

export function points (id) {
  return request({
    url: 'user/edit/points',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doPoints (data) {
  return request({
    url: 'user/edit/points.do',
    method: 'post',
    data
  })
}
