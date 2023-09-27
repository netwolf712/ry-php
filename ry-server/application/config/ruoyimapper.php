<?php
//ruoyi接口映射

//login.js
$ruoyiApiMapper['post']['login'] = "sys_user/login";
$ruoyiApiMapper['get']['register'] = "sys_user/register";
$ruoyiApiMapper['get']['getInfo'] = "sys_user/getInfo";
$ruoyiApiMapper['post']['logout'] = "sys_user/logout";
$ruoyiApiMapper['get']['captchaImage'] = "verify_code/index";

//menu.js
$ruoyiApiMapper['get']['getRouters'] = "sys_menu/getRouters";

//server.js
$ruoyiApiMapper['get']['monitor']['server'] = "monitor/server";

//operlog.js
$ruoyiApiMapper['get']['monitor']['operlog']['list'] = "sys_oper_log/get_oper_log_list";
$ruoyiApiMapper['delete']['monitor']['operlog']['index'] = "sys_oper_log/delete_oper_log";
$ruoyiApiMapper['delete']['monitor']['operlog']['clean'] = "sys_oper_log/clear_oper_log";

//logininfo.js
$ruoyiApiMapper['get']['monitor']['logininfor']['list'] = "sys_login_info/get_login_info_list";
$ruoyiApiMapper['delete']['monitor']['logininfor']['index'] = "sys_login_info/delete_login_info";
$ruoyiApiMapper['delete']['monitor']['logininfor']['clean'] = "sys_login_info/clear_login_info";
$ruoyiApiMapper['get']['monitor']['logininfor']['unlock'] = "sys_login_info/unlock_by_username";    //解锁用户密码出错次数限制，尚未实现

//config.js
$ruoyiApiMapper['get']['system']['config']['list'] = "sys_config/get_config_list";
$ruoyiApiMapper['get']['system']['config']['index'] = "sys_config/get_config";
$ruoyiApiMapper['get']['system']['config']['configKey'] = "sys_config/get_config_by_key";
$ruoyiApiMapper['post']['system']['config'] = "sys_config/update_config";
$ruoyiApiMapper['put']['system']['config'] = "sys_config/update_config";
$ruoyiApiMapper['delete']['system']['config'] = "sys_config/delete_config";

//user.js
$ruoyiApiMapper['get']['system']['user']['list'] = "sys_user/get_sys_user_list";
$ruoyiApiMapper['get']['system']['user']['index'] = "sys_user/get_sys_user_info";
$ruoyiApiMapper['post']['system']['user']['index'] = "sys_user/update_sys_user";
$ruoyiApiMapper['put']['system']['user']['index'] = "sys_user/update_sys_user";
$ruoyiApiMapper['delete']['system']['user']['index'] = "sys_user/delete_sys_user";
$ruoyiApiMapper['put']['system']['user']['resetPwd'] = "sys_user/reset_user_password";
$ruoyiApiMapper['put']['system']['user']['changeStatus'] = "sys_user/update_user_status";
$ruoyiApiMapper['get']['system']['user']['profile']['index'] = "sys_user/get_profile_info";
$ruoyiApiMapper['put']['system']['user']['profile']['index'] = "sys_user/update_profile_info";
$ruoyiApiMapper['put']['system']['user']['profile']['updatePwd'] = "sys_user/update_profile_password";
$ruoyiApiMapper['post']['system']['user']['profile']['avatar'] = "upload/upload_avatar";
$ruoyiApiMapper['get']['system']['user']['authRole'] = "sys_user/get_user_role";
$ruoyiApiMapper['put']['system']['user']['authRole'] = "sys_user/update_user_role";
$ruoyiApiMapper['get']['system']['user']['deptTree'] = "sys_dept/select_dept_tree";

//role.js
$ruoyiApiMapper['get']['system']['role']['list'] = "sys_role/get_role_list";
$ruoyiApiMapper['get']['system']['role']['index'] = "sys_role/get_role";
$ruoyiApiMapper['post']['system']['role'] = "sys_role/update_role";
$ruoyiApiMapper['put']['system']['role']['index'] = "sys_role/update_role";
$ruoyiApiMapper['put']['system']['role']['dataScope'] = "sys_role/update_role_data_scope";
$ruoyiApiMapper['put']['system']['role']['changeStatus'] = "sys_role/update_role_status";
$ruoyiApiMapper['delete']['system']['role']['index'] = "sys_role/delete_role";
$ruoyiApiMapper['get']['system']['role']['authUser']['allocatedList'] = "sys_role/get_allocated_user_list";
$ruoyiApiMapper['get']['system']['role']['deptTree'] = "sys_dept/get_dept_tree_by_role_id";


//post.js
$ruoyiApiMapper['get']['system']['post']['list'] = "sys_post/get_post_list";
$ruoyiApiMapper['get']['system']['post']['index'] = "sys_post/get_post";
$ruoyiApiMapper['post']['system']['post'] = "sys_post/update_post";
$ruoyiApiMapper['put']['system']['post'] = "sys_post/update_post";
$ruoyiApiMapper['delete']['system']['post'] = "sys_post/delete_post";

//menu.js
$ruoyiApiMapper['get']['system']['menu']['list'] = "sys_menu/get_menu_list";
$ruoyiApiMapper['get']['system']['menu']['index'] = "sys_menu/get_menu";
$ruoyiApiMapper['get']['system']['menu']['treeselect'] = "sys_menu/select_menu_tree";
$ruoyiApiMapper['get']['system']['menu']['roleMenuTreeselect'] = "sys_menu/get_menu_list_by_roleId";
$ruoyiApiMapper['post']['system']['menu'] = "sys_menu/update_menu";
$ruoyiApiMapper['put']['system']['menu'] = "sys_menu/update_menu";
$ruoyiApiMapper['delete']['system']['menu'] = "sys_menu/delete_menu";

//dept.js
$ruoyiApiMapper['get']['system']['dept']['list'] = "sys_dept/get_dept_list";
$ruoyiApiMapper['get']['system']['dept']['index'] = "sys_dept/get_dept";
$ruoyiApiMapper['post']['system']['dept'] = "sys_dept/update_dept";
$ruoyiApiMapper['put']['system']['dept'] = "sys_dept/update_dept";
$ruoyiApiMapper['delete']['system']['dept'] = "sys_dept/delete_dept";

//dict/type.js
$ruoyiApiMapper['get']['system']['dict']['type']['list'] = "sys_dict_type/get_dict_list";
$ruoyiApiMapper['get']['system']['dict']['type']['index'] = "sys_dict_type/get_dict_type";
$ruoyiApiMapper['post']['system']['dict']['type'] = "sys_dict_type/update_dict_type";
$ruoyiApiMapper['put']['system']['dict']['type'] = "sys_dict_type/update_dict_type";
$ruoyiApiMapper['delete']['system']['dict']['type']['index'] = "sys_dict_type/delete_dict_type";
$ruoyiApiMapper['delete']['system']['dict']['type']['refreshCache'] = "sys_dict_type/refresh_cache";    //未实现
$ruoyiApiMapper['get']['system']['dict']['type']['optionselect'] = "sys_dict_type/get_dict_list";

//dict/data.js
$ruoyiApiMapper['get']['system']['dict']['data']['list'] = "sys_dict_type/get_dict_data_list";
$ruoyiApiMapper['get']['system']['dict']['data']['index'] = "sys_dict_type/get_dict_data";
$ruoyiApiMapper['get']['system']['dict']['data']['type'] = "sys_dict_type/get_dict_data_by_type";
$ruoyiApiMapper['post']['system']['dict']['data'] = "sys_dict_type/update_dict_data";
$ruoyiApiMapper['put']['system']['dict']['data'] = "sys_dict_type/update_dict_data";
$ruoyiApiMapper['delete']['system']['dict']['data'] = "sys_dict_type/delete_dict_data";