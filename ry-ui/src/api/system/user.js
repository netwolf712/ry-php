import request from '@/utils/request'
import { parseStrEmpty } from "@/utils/ruoyi";

// 查询用户列表
export function listUser(query) {
  return request({
    url: 'sys_user/get_sys_user_list',
    method: 'get',
    params: query
  })
}

// 查询用户详细
export function getUser(userId) {
  return request({
    url: 'sys_user/get_sys_user_info/' + userId,
    method: 'get'
  })
}

// 新增用户
export function addUser(data) {
  return request({
    url: 'sys_user/update_sys_user',
    method: 'post',
    data: data
  })
}

// 修改用户
export function updateUser(data) {
  return request({
    url: 'sys_user/update_sys_user',
    method: 'put',
    data: data
  })
}

// 删除用户
export function delUser(userId) {
  return request({
    url: 'sys_user/delete_sys_user/' + userId,
    method: 'delete'
  })
}

// 用户密码重置
export function resetUserPwd(userId, password) {
  const data = {
    userId,
    password
  }
  return request({
    url: 'sys_user/reset_user_password',
    method: 'put',
    data: data
  })
}
// 用户密码重置
export function resetSelfPwd(password) {
  const data = {
    password
  }
  return request({
    url: 'sys_user/reset_self_password',
    method: 'put',
    data: data
  })
}

// 用户状态修改
export function changeUserStatus(userId, status) {
  const data = {
    userId,
    status
  }
  return request({
    url: 'sys_user/update_user_status',
    method: 'put',
    data: data
  })
}

// 查询用户个人信息
export function getUserProfile() {
  return request({
    url: 'sys_user/get_profile_info',
    method: 'get'
  })
}

// 修改用户个人信息
export function updateUserProfile(data) {
  return request({
    url: 'sys_user/update_profile_info',
    method: 'put',
    data: data
  })
}

// 用户密码重置
export function updateUserPwd(oldPassword, newPassword) {
  const data = {
    oldPassword,
    newPassword
  }
  return request({
    url: 'sys_user/update_profile_password',
    method: 'put',
    data: data
  })
}

// 用户头像上传
export function uploadAvatar(data) {
  return request({
    url: 'upload/upload_avatar',
    method: 'post',
    data: data
  })
}

// 查询授权角色
export function getAuthRole(userId) {
  return request({
    url: 'sys_user/get_user_role/' + userId,
    method: 'get'
  })
}

// 保存授权角色
export function updateAuthRole(data) {
  return request({
    url: 'sys_user/update_user_role',
    method: 'put',
    params: data
  })
}

//部门用户
/**
 * 获取部门用户列表
 * @param {*} query 
 * @returns 
 */
export function listDeptUser(query) {
  return request({
    url: 'sys_user/get_dept_user_list',
    method: 'get',
    params: query
  })
}


/**
 * 查询部门用户详细
 * @param {*} userId 
 * @returns 
 */
export function getDeptUser(userId) {
  return request({
    url: 'gdStaffApi/get_sys_user_info/' + userId,
    method: 'get'
  })
}

/**
 * 新增部门用户
 * @param {*} data 
 * @returns 
 */
export function addDeptUser(data) {
  return request({
    url: 'gdStaffApi/update_dept_user',
    method: 'post',
    data: data
  })
}

/**
 * 修改部门用户
 * @param {*} data 
 * @returns 
 */
export function updateDeptUser(data) {
  return request({
    url: 'gdStaffApi/update_dept_user',
    method: 'put',
    data: data
  })
}

/**
 * 删除部门用户
 * @param {*} userId 
 * @returns 
 */
export function delDeptUser(userDeptId) {
  return request({
    url: 'gdStaffApi/delete_dept_user?userDeptIds=' + userDeptId,
    method: 'delete'
  })
}

/**
 * 用户部门状态修改
 * @param {*} userDeptId 
 * @param {*} status 
 * @returns 
 */
export function changeDeptUserStatus(userDeptId, status) {
  const data = {
    userDeptId:userDeptId,
    status:status
  }
  return request({
    url: 'gdStaffApi/update_dept_user_status',
    method: 'put',
    data: data
  })
}