import request from '@/utils/request'

// 查询登录日志列表
export function list(query) {
  return request({
    url: '/sys_login_info/get_login_info_list',
    method: 'get',
    params: query
  })
}

// 删除登录日志
export function delLogininfor(infoId) {
  return request({
    url: '/sys_login_info/delete_login_info/' + infoId,
    method: 'delete'
  })
}

// 清空登录日志
export function cleanLogininfor() {
  return request({
    url: '/sys_login_info/clear_login_info',
    method: 'delete'
  })
}
