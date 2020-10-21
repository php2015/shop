import { getQueryObject, param } from '@/utils'
import md5 from 'js-md5'

const secret = '45c9d4691906f50e3ed5d6713f53967c'

export default function getSign (url, params = []) {
  let paramsObj = getQueryObject(url)
  paramsObj = Object.assign(paramsObj, params)

  // 排序、去重
  const sortParamsArray = Object.keys(paramsObj).sort()
  const map = new Map()
  const request = {}
  sortParamsArray.forEach(key => {
    const value = paramsObj[key]
    if (
      value !== '' &&
      value !== null &&
      value !== undefined &&
      value !== 0 &&
      value !== '0' &&
      typeof value !== 'object' &&
      !map.has(key)) {
      request[key] = value
    }
  })
  return md5(param(request) + secret)
}
