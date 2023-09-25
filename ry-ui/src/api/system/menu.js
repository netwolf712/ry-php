import request from '@/utils/request'

// 查询菜单列表
export function listMenu(query) {
  return request({
    url: 'sys_menu/get_menu_list',
    method: 'get',
    params: query
  })
}

// 查询菜单详细
export function getMenu(menuId) {
  return request({
    url: 'sys_menu/get_menu/' + menuId,
    method: 'get'
  })
}

// 查询菜单下拉树结构
export function treeselect() {
  return request({
    url: 'sys_menu/select_menu_tree',
    method: 'get'
  })
}

// 根据角色ID查询菜单下拉树结构
export function roleMenuTreeselect(roleId) {
  return request({
    url: 'sys_menu/get_menu_list_by_roleId/' + roleId,
    method: 'get'
  })
}

// 新增菜单
export function addMenu(data) {
  return request({
    url: 'sys_menu/update_menu',
    method: 'post',
    data: data
  })
}

// 修改菜单
export function updateMenu(data) {
  return request({
    url: 'sys_menu/update_menu',
    method: 'put',
    data: data
  })
}

// 删除菜单
export function delMenu(menuId) {
  return request({
    url: 'sys_menu/delete_menu/' + menuId,
    method: 'delete'
  })
}