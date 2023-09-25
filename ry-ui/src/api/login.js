import request from '@/utils/request'

// 登录方法
export function login(username, password, code, uuid) {
  const data = {
    username,
    password,
    code,
    uuid
  }
  return request({
    url: 'sys_user/login',
    headers: {
      isToken: false
    },
    method: 'post',
    data: data
  })
}

// 注册方法
export function register(data) {
  return request({
    url: 'sys_user/register',
    headers: {
      isToken: false
    },
    method: 'post',
    data: data
  })
}

// 获取用户详细信息
export function getInfo() {
  return request({
    url: 'sys_user/getInfo',
    method: 'get'
  })
}

// 退出方法
export function logout() {
  return request({
    url: 'sys_user/logout',
    method: 'post'
  })
}

// 获取验证码
export function getCodeImg() {
  return request({
    url: 'verifycode/index/2',
    headers: {
      isToken: false
    },
    method: 'get',
    timeout: 20000
  })
}

// 获取短信验证码
export function getSmsCode(mobile, type, tokeen) {
  const data = {
    type,
    mobile,
    tokeen
  }
  return request({
    url: 'sys_user/get_reg_sms_code',
    headers: {
      isToken: false
    },
    method: 'post',
    data: data
  })
}
