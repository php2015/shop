import request from '@/utils/request'

export function list (data) {
  return request({
    url: 'order',
    method: 'get',
    params: data
  })
}

export function detail (id) {
  return request({
    url: 'order/detail',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function shipment (id) {
  return request({
    url: 'order/shipment',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function doShipment (data) {
  return request({
    url: 'order/shipment.do',
    method: 'post',
    data
  })
}

export function doPrints (id) {
  return request({
    url: 'order/prints.do',
    method: 'post',
    data: {
      id: id
    }
  })
}
