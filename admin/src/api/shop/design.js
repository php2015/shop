import request from '@/utils/request'

export function fetch (page) {
  return request({
    url: 'shop/design',
    method: 'get',
    params: {
      page: page
    }
  })
}

export function doSave (params, page) {
  return request({
    url: 'shop/design/save.do',
    method: 'post',
    data: {
      params: params,
      page: page
    }
  })
}

export function goodsCategory () {
  return request({
    url: 'shop/design/goods/category'
  })
}

export function goodsGroup () {
  return request({
    url: 'shop/design/goods/group'
  })
}
