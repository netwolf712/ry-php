import request from '@/utils/request'

// 查询字典类型列表
export function listType(query) {
  return request({
    url: 'sys_dict_type/get_dict_list',
    method: 'get',
    params: query
  })
}

// 查询字典类型详细
export function getType(dictId) {
  return request({
    url: 'sys_dict_type/get_dict_type/' + dictId,
    method: 'get'
  })
}

// 新增字典类型
export function addType(data) {
  return request({
    url: 'sys_dict_type/update_dict_type',
    method: 'post',
    data: data
  })
}

// 修改字典类型
export function updateType(data) {
  return request({
    url: 'sys_dict_type/update_dict_type',
    method: 'put',
    data: data
  })
}

// 删除字典类型
export function delType(dictId) {
  return request({
    url: 'sys_dict_type/delete_dict_type/' + dictId,
    method: 'delete'
  })
}

// 刷新字典缓存
export function refreshCache() {
  return request({
    url: '/system/dict/type/refreshCache',
    method: 'delete'
  })
}

// 获取字典选择框列表
export function optionselect() {
  return request({
    url: 'sys_dict_type/get_dict_list',
    method: 'get'
  })
}