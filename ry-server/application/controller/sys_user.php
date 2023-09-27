<?php

/**
 * Class Problem
 * Formerly named "Error", but as PHP 7 does not allow Error as class name anymore (as there's a Error class in the
 * PHP core itself) it's now called "Problem"
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Sys_user extends Controller
{
    private $User_model = NULL;
    private $Sys_menu_model = NULL;
	private $Sys_role_model = NULL;
    private $Sys_pos_model = NULL;
	private $Sys_dept_model = NULL;
	private $Sys_user_role_model = NULL;
	private $Sys_user_post_model = NULL;
	private $Sys_user_dept_model = NULL;
	private $Sys_login_info_model = NULL;
	private $Sys_oper_log_model = NULL;
	private $_userVo = "user_name as userName,user_id as userId,nick_name as nickName,email,phonenumber,status,avatar
	,dept_id as deptId
	,sex
	,login_ip as loginIp,login_date as loginDate
	,del_flag as delFlag,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark";

    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
        $this->Sys_menu_model = Helper::load_model("Sys_menu",$this->db);
        $this->Sys_role_model = Helper::load_model("Sys_role",$this->db);
		$this->Sys_post_model = Helper::load_model("Sys_post",$this->db);
		$this->Sys_dept_model = Helper::load_model("Sys_dept",$this->db);
		$this->Sys_user_role_model = Helper::load_model("Sys_user_role",$this->db);
		$this->Sys_user_post_model = Helper::load_model("Sys_user_post",$this->db);
		$this->Sys_user_dept_model = Helper::load_model("Sys_user_dept",$this->db);
		$this->Sys_login_info_model = Helper::load_model("Sys_login_info",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }

	//加盐算法
	private function _createPasswordSALT($user, $salt, $password){	     
	    return md5(strtolower($user).$salt.$password);
	} 

    private function _get_role_permission($userId){
		if(_is_admin($userId)){
			return array("admin");
		}else{
			return $this->Sys_role_model->selectRolePermissionByUserId($userId);
		}
	}
	private function _get_menu_permission($userId){
		if(_is_admin($userId)){
			return array("*:*:*");
		}else{
			return $this->Sys_menu_model->selectMenuPermsByUserId($userId);
		}
	}
	public function getInfo(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("user_id as userId,user_name as userName,avatar",array('user_id'=>$user_id));
		if(!$userInfo ){
			printAjaxError('user_id', '用户不存在');
		}
		$userInfo['token'] = getEnUserId();

		$userInfo['admin']=_is_admin($user_id);
		$permsList = array();
		$tmpPermsLIst = $this->_get_menu_permission($user_id);
		if($tmpPermsLIst){
			foreach($tmpPermsLIst as $key=>$value){
				if(isset($value['perms'])){
					array_push($permsList,$value['perms']);
				}else{
					array_push($permsList,$value);
				}
			}
		}
		printAjaxRaw(array('code'=>200,'permissions'=>$permsList,'roles'=>$this->_get_role_permission($user_id),'msg'=>"操作成功",'user'=>$userInfo));
	} 

	/**
	 * 写入登录日志
	 */
	private function _write_login_log($username,$msg,$status,$loginTime){
		$fields = array(
			'user_name'=>$username,
			'ipaddr'=>getIp(),
			'browser'=>getClientBroswerInfo(),
			'os'=>getClientOsInfo(),
			'status'=>$status,
			'msg'=>$msg,
			'login_time'=>$loginTime
		);
		$this->Sys_login_info_model->save($fields);
	}
	/**
	 * 登录接口
	 * @param username 用户名
	 * @param password 密码
	 * 
	 * @return json
	 */
	public function login() {

		$jsonData = getJsonData();
		$loginTime = date('Y-m-d H:i:s',time());
		if($jsonData ){
			if(ENABLE_IMAGE_VERIFY_CODE){
				if (!isset($jsonData->code)){
					printAjaxError('code', '验证码不能为空');
				}
				if(!VerifyCode::check($jsonData->code)){
					printAjaxError('code', '错误的验证码');
				}
			}
		    if (!isset($jsonData->username) || !$jsonData->username) {
				$this->_write_login_log("",'用户名不能为空',FAILURE,$loginTime);
		        printAjaxError('username', '用户名不能为空');
		    }
		    if (!isset($jsonData->password) || !$jsonData->password) {
				$this->_write_login_log($jsonData->username,'登录密码不能为空',FAILURE,$loginTime);
		        printAjaxError('password', '登录密码不能为空');
		    }
		    $username = trim($jsonData->username);
		    $password = $jsonData->password;			
		    $count = $this->User_model->rowCount(array('lower(user_name)'=>strtolower($username)));
	        if (!$count) {
				$this->_write_login_log($jsonData->username,'用户名不存在，登录失败',FAILURE,$loginTime);
	            printAjaxError('username', '用户名不存在，登录失败');
	        }
		    $userInfo = $this->User_model->login($username, $password);
		    if (! $userInfo) {
				$this->_write_login_log($jsonData->username,'用户名或密码错误，登录失败',FAILURE,$loginTime);
		        printAjaxError('fail', '用户名或密码错误，登录失败');
		    }
			$logintoken=time();
		    $fields = array(
				          'login_date'=>$loginTime,
				          'login_ip'=>getIp(),
				          );
			if($this->User_model->save($fields, array('user_id'=>$userInfo['user_id']))) {
			   $userInfo['logintoken']=$logintoken;
				$en_user_id = gen_user_code($userInfo['user_id']);
				$userInfo['en_user_id'] = $en_user_id;
				$userInfo['token'] = $en_user_id;
				unset($userInfo['password']);
				$redis = new CI_Redis();
				//将用户信息存入redis
				$redis->set($en_user_id,$userInfo['user_id']);
				$redis->EXPIRE($en_user_id, SESSION_TIME); 
				$this->_write_login_log($jsonData->username,'登录成功',SUCCESS,$loginTime);
				//printAjaxData($userInfo);
				printAjaxRaw(array('code'=>200,'token'=>$en_user_id));	
			   
			} else {
				$this->_write_login_log($jsonData->username,'登录失败',FAILURE,$loginTime);
			    printAjaxError('fail', '登录失败');
			}
		}else{
			printAjaxError('fail', '无效的请求，登录失败');
			$this->_write_login_log("",'无效的请求，登录失败',FAILURE,$loginTime);
		}
	}    

	public function logout(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			//printAjaxError('username', '会话已失效，请重新登录');
			//解决ruoyi的bug，否则假如session失效，又要logout，就会导致logout失败
			//然后若依的前端页面一直无法返回到登录页面，一直尝试logout
			printAjaxSuccess('','操作成功');
		}		
		$this->redis->set($user_id,"");
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/logout',"");		
		printAjaxSuccess('','',$operFields,$this->Sys_oper_log_model);
	}

		/**
	 * 获取登录用户的信息
	 */
	public function get_profile_info(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}

		$deptWhere = "del_flag = 0";

		$userInfo = $this->User_model->get($this->_userVo,array('user_id'=>$user_id));

		//用户已有的角色
		$userRoles= $this->Sys_role_model->selectRolePermissionByUserId($user_id);
		$roleIds = array();
		$roleGroup = "";
		if($userRoles){
			foreach($userRoles as $key=>$value){
				if($roleGroup){
					$roleGroup .= ",";
				}
				$roleGroup .= $value['roleName'];
				array_push($roleIds,intval($value['roleId']));
			}
		}

		//用户已有的岗位
		$postIds = array();
		$postGroup = "";
		$userPosts = $this->Sys_post_model->selectPostByUserId($user_id);
		if($userPosts){
			foreach($userPosts as $key=>$value){
				if($postGroup){
					$postGroup .= ",";
				}
				$postGroup .= $value['post_name'];
				array_push($postIds,intval($value['post_id']));
			}
		}

		//用户已挂载的单位节点
		$deptIds = array();
		$userDepts = $this->Sys_dept_model->selectDeptByUserId($user_id);
		if($userDepts){
			foreach($userDepts as $key=>$value){
				array_push($deptIds,intval($value['dept_id']));
			}
		}

		$userInfo['admin'] = _is_admin($userInfo['userId']);
		$userInfo['userId'] = intval($userInfo['userId']);
		$userInfo['status'] = $userInfo['status']; 
		$userInfo['roleIds'] = $roleIds;
		$userInfo['postIds'] = $postIds;
		$userInfo['deptIds'] = $deptIds;
		$userInfo['roles'] = $userRoles;
		$userInfo['posts'] = $userPosts;
		$userInfo['depts'] = $userDepts;

		unset($userInfo['password']);
		printAjaxRaw(array('data'=>$userInfo
							,'postGroup'=>$postGroup
							,'roleGroup'=>$roleGroup,'success'=>true));
	}

	/**
	 * 更新登录用户的信息
	 */
	public function update_profile_info(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_profile_info',$jsonData);
		if($jsonData ){
			$otherUserId = $user_id;
			if($otherUserId){
				//如果用户id不为空，则说明是修改
				//检查用户名是否存在
				$tmpUser = $this->User_model->get("*",array('user_name'=>$jsonData->userName));
				if($tmpUser && $tmpUser['user_id'] != $otherUserId){
					printAjaxError('username', '此用户名已存在！',$operFields,$this->Sys_oper_log_model);
				}
				$tmpUser = $this->User_model->get("*",array('phonenumber'=>$jsonData->phonenumber));
				if($tmpUser && $tmpUser['user_id'] != $otherUserId){
					printAjaxError('phonenumber', '此手机号码已存在！',$operFields,$this->Sys_oper_log_model);
				}
				$tmpUser = $this->User_model->get("*",array('email'=>$jsonData->email));
				if($tmpUser && $tmpUser['user_id'] != $otherUserId){
					printAjaxError('email', '此邮箱已存在！',$operFields,$this->Sys_oper_log_model);
				}
			}else{
				$tmpUser = $this->User_model->get("*",array('user_name'=>$jsonData->userName));
				if($tmpUser){
					printAjaxError('username', '此用户名已存在！',$operFields,$this->Sys_oper_log_model);
				}
				$tmpUser = $this->User_model->get("*",array('phonenumber'=>$jsonData->phonenumber));
				if($tmpUser){
					printAjaxError('phonenumber', '此手机号码已存在！',$operFields,$this->Sys_oper_log_model);
				}
				if(isset($jsonData->email)){
					$tmpUser = $this->User_model->get("*",array('email'=>$jsonData->email));
					if($tmpUser){
						printAjaxError('email', '此邮箱已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
			}
			$fields = array(
				'user_name'=>$jsonData->userName,
				'phonenumber'=>$jsonData->phonenumber
			);
			if(isset($jsonData->email)){
				$fields['email'] = $jsonData->email;
			}
			if(isset($jsonData->nickName)){
				$fields['nick_name'] = $jsonData->nickName;
			}
			if(isset($jsonData->remark)){
				$fields['remark'] = $jsonData->remark;
			}
			if($otherUserId){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}
			$tmpId = $this->User_model->save($fields,array('user_id'=>$otherUserId));
			printAjaxSuccess('',"修改成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}
	public function update_profile_password($params){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		if(!$jsonData){
			$jsonData = $params;
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_profile_password',$jsonData);
		if($jsonData){
			// $oldpassword = trim($this->input->get('oldPassword', TRUE));
			// $passwd = trim($this->input->get('newPassword', TRUE));	
			if(!isset($jsonData->oldPassword) || !$jsonData->oldPassword){
				printAjaxError('password', '原始密码不能为空',$operFields,$this->Sys_oper_log_model);
			}
			if(!isset($jsonData->newPassword) || !$jsonData->newPassword){
				printAjaxError('password', '新密码不能为空',$operFields,$this->Sys_oper_log_model);
			}			
			$oldpassword = trim($jsonData->oldPassword);
			$passwd = trim($jsonData->newPassword);				
			$oldpassword = $this->_createPasswordSALT($userInfo['user_name'],$userInfo['create_time'], $oldpassword);
			if($oldpassword != $userInfo['password']){
				printAjaxError('oldpassword', '原始密码不正确',$operFields,$this->Sys_oper_log_model);
			}
			$fields = array('password'=>$this->_createPasswordSALT($userInfo['user_name'],$userInfo['create_time'], $passwd)
						,'update_by'=>$userInfo['user_name']
						,'update_time'=>date("YmdHis", time())
					);
			$this->User_model->save($fields,array('user_id'=>$user_id));
			printAjaxSuccess('',"重置成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
		
	}

	/**
	 * 获取查询系统用户时的数据范围限制
	 * @param $user_id 查询者的user_id
	 */
	private function _get_sys_user_data_scope($user_id){
		$dataScopeWhere = "";
		if(_is_admin($user_id)){
			return "";
		}
		$roles = $this->Sys_role_model->selectRolePermissionByUserId($user_id);
		if($roles){
			foreach($roles as $key=>$value){
				if(strlen($dataScopeWhere) > 0){
					$dataScopeWhere .= " OR ";
				}				
				if($value['dataScope'] == $this->_DATA_SCOPE_ALL){
					//如果是全部，则没必要再加条件过滤了。
					return "";
				}else if($value['dataScope'] == $this->_DATA_SCOPE_DEPT){
					//如果是本单位人员
					$dataScopeWhere .= " id in (select sud.user_id from sys_user_dept as sud where sud.dept_id in (select sud2.dept_id from sys_user_dept as sud2 where sud2.user_id = {$user_id}))";
				}else if($value['dataScope'] == $this->_DATA_SCOPE_DEPT_AND_CHILD){
					//如果是本单位及以下人员
					$subWhere = "select sud2.dept_id from sys_user_dept as sud2 where sud2.user_id = {$user_id}";
					$deptIdList = $this->Sys_user_dept_model->gets2("dept_id","user_id = {$user_id}");
					if($deptIdList){
						foreach($deptIdList as $key=>$value){
							$subWhere .= (" or sud2.dept_id in (select dept_id from sys_dept where find_in_set( ".$value['dept_id']." , ancestors ) )");
						}
					}					
					$dataScopeWhere .= " id in (select sud.user_id from sys_user_dept as sud where sud.dept_id in ({$subWhere})";

				}else if($value['dataScope'] == $this->_DATA_SCOPE_SELF){
					//如果仅限于获取自身数据
					$dataScopeWhere .= " id = {$user_id}";
				}
			}
			return $dataScopeWhere;
		}else{
			//如果没有角色，则仅限于获取自身数据
			return " id = {$user_id}";
		}
	}
	public function get_sys_user_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		$whereStr = "del_flag = 0";
		$pageNum = 1;
		$pageSize = 10;
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".trim($jsonData->status); 
			}
			if(isset($jsonData->realName) && !empty($jsonData->realName)){
				$whereStr = $whereStr." and real_name like '%".trim($jsonData->realName)."%'"; 
			}
			if(isset($jsonData->phonenumber) && !empty($jsonData->phonenumber)){
				$whereStr = $whereStr." and phonenumber like '%".trim($jsonData->phonenumber)."%'"; 				
			}
			$userDeptWhere = "";
			if(isset($jsonData->deptId) && $jsonData->deptId && $jsonData->deptId != 100){
				$userDeptWhere = "dept_id in (select dept_id from sys_dept as sd where sd.dept_id = {$jsonData->deptId} or find_in_set( {$jsonData->deptId} , sd.ancestors ))";				
			}
			if(isset($jsonData->userType) && $jsonData->userType){
				if($userDeptWhere){
					$userDeptWhere .= " and ";
				}
				$userDeptWhere .= " user_type = {$jsonData->userType}";
			}
			if($userDeptWhere){
				$whereStr = $whereStr." and id in (select user_id from sys_user_dept where {$userDeptWhere})";
			}
			if(isset($jsonData->params) && !empty($jsonData->params)){
				$params = $jsonData->params;
				if(isset($params['beginTime'])){
					$whereStr = $whereStr." and create_time >= '".$params['beginTime']."'";
				}
				if(isset($params['endTime'])){
					$whereStr = $whereStr." and create_time <= '".$params['endTime']."'";
				}
			}
			if(isset($jsonData->pageNum) && $jsonData->pageNum){
				$pageNum = $jsonData->pageNum;
			}			
			if(isset($jsonData->pageSize) && $jsonData->pageSize){
				$pageSize = trim($jsonData->pageSize);
			}
		}
		//增加权限范围判断
		$dataScopeWhere = $this->_get_sys_user_data_scope($user_id);
		if(strlen($dataScopeWhere) > 0){
			$whereStr .= (" and (".$dataScopeWhere." ) ");
		}
		$list = $this->User_model->gets($this->_userVo,$whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if($list){
			foreach($list as $key=>$value){
				$list[$key]['admin'] = _is_admin($value['userId']);
				$list[$key]['userId'] = intval($value['userId']);
				unset($list[$key]['password']);
			}
		}

		$count = $this->User_model->rowCount($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}	
	public function get_user_role($otherUserId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get($this->_userVo,array('user_id'=>$otherUserId));

		$allRoles = $this->Sys_role_model->gets2("status = 0",100000,0);
		$userRoles = $this->Sys_role_model->selectRolePermissionByUserId($otherUserId);
		if($allRoles && $userRoles){
			foreach($allRoles as $allKey=>$allValue){
				$allRoles[$allKey]['roleId'] = intval($allValue['roleId']);
				foreach($userRoles as $key=>$value){
					if($value['roleId'] == $allValue['roleId']){
						$allRoles[$allKey]['flag'] = true;
						break;
					}
				}
			}
		}
		if(!_is_admin($otherUserId)){
			if($allRoles){
				$tmpRoles = array();
				foreach($allRoles as $allKey=>$allValue){
					if($allValue['roleKey'] != 'admin'){
						array_push($tmpRoles,$allValue);
					}
				}
				$allRoles = $tmpRoles;
			}
		}
		unset($userInfo['password']);
		printAjaxRaw(array('user'=>$userInfo,'roles'=>$allRoles));
	}

	public function update_user_role($params){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		if(!$jsonData){
			//兼容ruoyi的bug，明明请求类型给put，但是传参方式却用的urlparam
			$jsonData = $params;
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_user_role',$jsonData);			
		if(!$jsonData || !isset($jsonData->userId) ||!$jsonData->userId){
			printAjaxError('userId', '用户信息错误',$operFields,$this->Sys_oper_log_model);
		}

		//更新用户角色关系表
		$this->Sys_user_role_model->delete(array('user_id'=>$jsonData->userId));
		if(isset($jsonData->roleIds) && $jsonData->roleIds){
			$roleIds = $jsonData->roleIds;
			$roleIdsList = explode(',',$roleIds);
			if(!empty($roleIdsList)){
				foreach($roleIdsList as $key=>$value){
					$this->Sys_user_role_model->save(array('user_id'=>$jsonData->userId,'role_id'=>$value));
				}
			}else{
				$this->Sys_user_role_model->save(array('user_id'=>$jsonData->userId,'role_id'=>$roleIds));
			}
		}

		printAjaxSuccess('',"修改成功");
	}
	/**
	 * 获取查询系统用户时的数据范围限制
	 * @param $user_id 查询者的user_id
	 */
	private function _get_dept_data_scope($user_id){
		$dataScopeWhere = "";
		if(_is_admin($user_id)){
			return "";
		}
		$roles = $this->Sys_role_model->selectRolePermissionByUserId($user_id);
		if($roles){
			foreach($roles as $key=>$value){
				if(strlen($dataScopeWhere) > 0){
					$dataScopeWhere .= " OR ";
				}
				
				if($value['dataScope'] == _DATA_SCOPE_ALL){
					//如果是全部，则没必要再加条件过滤了。
					return "";
				}else if($value['dataScope'] == _DATA_SCOPE_DEPT){
					//如果是本单位人员
					$dataScopeWhere .= " dept_id in (select sud2.dept_id from sys_user_dept as sud2 where sud2.user_id = {$user_id})";
				}else if($value['dataScope'] == _DATA_SCOPE_DEPT_AND_CHILD){
					//如果是本单位及以下人员
					$subWhere = "select sud2.dept_id from sys_user_dept as sud2 where sud2.user_id = {$user_id}";
					$deptIdList = $this->Sys_user_dept_model->gets2("dept_id","user_id = {$user_id}");
					if($deptIdList){
						foreach($deptIdList as $key=>$value){
							$subWhere .= (" or sud2.dept_id in (select dept_id from sys_dept where find_in_set( ".$value['dept_id']." , ancestors ) )");
						}
					}					
					$dataScopeWhere .= " dept_id in ({$subWhere})";

				}else if($value['dataScope'] == _DATA_SCOPE_SELF){
					//如果仅限于获取自身数据
					$dataScopeWhere .= " dept_id in (select dept_id from sys_user_dept where user_id = {$user_id})";
				}
			}
			return $dataScopeWhere;
		}else{
			//如果没有角色，则仅限于获取自身数据
			return " dept_id in (select dept_id from sys_user_dept where user_id = {$user_id})";
		}
	}
	public function get_sys_user_info($otherUserId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$allRoles = $this->Sys_role_model->gets2("status = 0",100000,0);
		if($allRoles){
			foreach($allRoles as $key=>$value){
				$allRoles[$key]['roleId'] = intval($value['roleId']);
			}
		}
		$allPosts = $this->Sys_post_model->gets2("status = 0",100000,0);
		if($allPosts){
			foreach($allPosts as $key=>$value){
				$allPosts[$key]['postId'] = intval($value['postId']);
			}
		}
		$deptWhere = "del_flag = 0";
		$tmp = $this->_get_dept_data_scope($user_id);
		if($tmp){
			$deptWhere .= " and ".$tmp;
		}
		$allDepts = $this->Sys_dept_model->gets2($deptWhere,100000,0);
		if($allDepts){
			foreach($allDepts as $key=>$value){
				$allDepts[$key]['deptId'] = intval($value['deptId']);
			}
		}
		if(!$otherUserId || $otherUserId == 'undefined'){
			printAjaxRaw(array('roles'=>$allRoles,'posts'=>$allPosts,'depts'=>$allDepts));
		}
		$userInfo = $this->User_model->get($this->_userVo,array('user_id'=>$otherUserId));

		//用户已有的角色
		$userRoles= $this->Sys_role_model->selectRolePermissionByUserId($otherUserId);
		$roleIds = array();
		if($userRoles){
			foreach($userRoles as $key=>$value){
				array_push($roleIds,intval($value['roleId']));
			}
		}

		//用户已有的岗位
		$postIds = array();
		$userPosts = $this->Sys_post_model->selectPostByUserId($otherUserId);
		if($userPosts){
			foreach($userPosts as $key=>$value){
				array_push($postIds,intval($value['post_id']));
			}
		}

		//用户已挂载的单位节点
		$deptIds = array();
		$userDepts = $this->Sys_dept_model->selectDeptByUserId($otherUserId);
		if($userDepts){
			foreach($userDepts as $key=>$value){
				array_push($deptIds,intval($value['dept_id']));
			}
		}

		$userInfo['admin'] = _is_admin($userInfo['userId']);
		$userInfo['userId'] = intval($userInfo['userId']);
		$userInfo['roleIds'] = $roleIds;
		$userInfo['postIds'] = $postIds;
		$userInfo['deptIds'] = $deptIds;
		unset($userInfo['password']);
		printAjaxRaw(array('data'=>$userInfo
							,'roles'=>$allRoles
							,'roleIds'=>$roleIds
							,'posts'=>$allPosts
							,'postIds'=>$postIds
							,'depts'=>$allDepts
							,'deptIds'=>$deptIds));
	}

	public function update_sys_user(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_sys_user',$jsonData);		
		if($jsonData ){
			$otherUserId = NULL;
			if(isset($jsonData->userId)){
				$otherUserId = $jsonData->userId;
			}
			if($otherUserId){
				//如果用户id不为空，则说明是修改
				//检查用户名是否存在
				if(isset($jsonData->userName)){
					$tmpUser = $this->User_model->get("*",array('user_name'=>$jsonData->userName));
					if($tmpUser && $tmpUser['user_id'] != $otherUserId){
						printAjaxError('username', '此用户名已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
				if(isset($jsonData->phonenumber)){
					$tmpUser = $this->User_model->get("*",array('phonenumber'=>$jsonData->phonenumber));
					if($tmpUser && $tmpUser['user_id'] != $otherUserId && !empty($jsonData->phonenumber)){
						printAjaxError('phonenumber', '此手机号码已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
				if(isset($jsonData->email)){
					$tmpUser = $this->User_model->get("*",array('email'=>$jsonData->email));
					if($tmpUser && $tmpUser['user_id'] != $otherUserId && !empty($jsonData->email)){
						printAjaxError('email', '此邮箱已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
			}else{
				if(isset($jsonData->userName)){
					$tmpUser = $this->User_model->get("*",array('user_name'=>$jsonData->userName));
					if($tmpUser){
						printAjaxError('username', '此用户名已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
				if(isset($jsonData->phonenumber)){
					$tmpUser = $this->User_model->get("*",array('phonenumber'=>$jsonData->phonenumber));
					if($tmpUser && !empty($jsonData->phonenumber)){
						printAjaxError('phonenumber', '此手机号码已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
				if(isset($jsonData->email)){
					$tmpUser = $this->User_model->get("*",array('email'=>$jsonData->email));
					if($tmpUser && !empty($jsonData->email)){
						printAjaxError('email', '此邮箱已存在！',$operFields,$this->Sys_oper_log_model);
					}
				}
			}
			$fields = array(
				'user_name'=>$jsonData->userName,
				'dept_id'=>isset($jsonData->deptId) ? $jsonData->deptId : 100
			);
			if(isset($jsonData->phonenumber)){
				$fields['phonenumber'] = $jsonData->phonenumber;
			}
			if(isset($jsonData->status)){
				$fields['status'] = $jsonData->status;
			}
			if(isset($jsonData->email)){
				$fields['email'] = $jsonData->email;
			}
			if(isset($jsonData->nickName)){
				$fields['nick_name'] = $jsonData->nickName;
			}else{
				if(!$otherUserId){
					$fields['nick_name'] = $jsonData->userName;
				}
			}
			if(isset($jsonData->deptId)){
				$fields['dept_id'] = $jsonData->deptId;
			}			
			if(isset($jsonData->sex)){
				$fields['sex'] = $jsonData->sex;
			}
			if(isset($jsonData->remark)){
				$fields['remark'] = $jsonData->remark;
			}
			if($otherUserId){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
				$passwd = "123456";
				$fields['password'] = $this->_createPasswordSALT($jsonData->userName,$fields['create_time'], $passwd);
			}
			$tmpId = $this->User_model->save($fields,$otherUserId ? array('user_id'=>$otherUserId) : NULL);
			if(!$otherUserId){
				$otherUserId = $tmpId;
			}else{
				//先删除用户现有角色
				$this->Sys_user_role_model->delete(array('user_id'=>$otherUserId));
				//先删除用户现有岗位
				$this->Sys_user_post_model->delete(array('user_id'=>$otherUserId));
				//先删除用户现有单位
				//$this->Sys_user_dept_model->delete(array('user_id'=>$otherUserId));
			}
			//重新插入用户角色
			if(!empty($jsonData->roleIds)){
				foreach($jsonData->roleIds as $key=>$value){
					$this->Sys_user_role_model->save(array('user_id'=>$otherUserId,'role_id'=>$value));
				}
			}

			//重新插入用户岗位
			if(!empty($jsonData->postIds)){
				foreach($jsonData->postIds as $key=>$value){
					$this->Sys_user_post_model->save(array('user_id'=>$otherUserId,'post_id'=>$value));
				}
			}

			printAjaxSuccess('',$otherUserId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}

	public function reset_user_password(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/reset_user_password',$jsonData);			
		if($jsonData && isset($jsonData->userId) && $jsonData->userId && !empty($jsonData->password)){
			$otherUserId = $jsonData->userId;
			if($otherUserId){
				$otherUserInfo = $this->User_model->get("*",array('user_id'=>$otherUserId));
				if(!$otherUserInfo){
					printAjaxError('userInfo', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
				}
				$passwd = $jsonData->password;
				$fields = array('password'=>$this->_createPasswordSALT($otherUserInfo['user_name'],$otherUserInfo['create_time'], $passwd)
					,'update_by'=>$userInfo['user_name']
					,'update_time'=>date("YmdHis", time())
				);
				$this->User_model->save($fields,array('user_id'=>$otherUserId));
				printAjaxSuccess('',"重置成功",$operFields,$this->Sys_oper_log_model);
			}else{
				printAjaxError('userId', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
			}
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}

	public function reset_self_password(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/reset_self_password',$jsonData);			
		if($jsonData && !empty($jsonData->password)){
			$otherUserId = $user_id;
			if($otherUserId){
				$otherUserInfo = $this->User_model->get("*",array('user_id'=>$otherUserId));
				if(!$otherUserInfo){
					printAjaxError('userInfo', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
				}
				$passwd = $jsonData->password;
				$fields = array('password'=>$this->_createPasswordSALT($otherUserInfo['user_name'],$otherUserInfo['create_time'], $passwd)
					,'update_by'=>$userInfo['user_name']
					,'update_time'=>date("YmdHis", time())
				);
				$this->User_model->save($fields,array('user_id'=>$otherUserId));
				printAjaxSuccess('',"重置成功",$operFields,$this->Sys_oper_log_model);
			}else{
				printAjaxError('userId', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
			}
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}

	public function update_user_password(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_user_password',$jsonData);		
		if($jsonData ){
			$otherUserId = NULL;
			if(isset($jsonData->userId) && $jsonData->userId){
				$otherUserId = $jsonData->userId;
			}
			if($otherUserId){
				
				if(!isset($jsonData->password) || !$jsonData->password){
					printAjaxError('password', '密码不能为空',$operFields,$this->Sys_oper_log_model);
				}
				$otherUserInfo = $this->User_model->get("*",array('user_id'=>$otherUserId));
				if(!$otherUserInfo){
					printAjaxError('userInfo', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
				}
				if(empty($jsonData->oldPassword)){
					printAjaxError('oldpassword', '原始密码不能为空',$operFields,$this->Sys_oper_log_model);
				}			
				$oldpassword = $this->_createPasswordSALT($otherUserInfo['user_name'],$otherUserInfo['create_time'], $jsonData->oldPassword);
				if($oldpassword != $otherUserInfo['password']){
					printAjaxError('oldpassword', '原始密码不正确',$operFields,$this->Sys_oper_log_model);
				}
				$passwd = $jsonData->password;
				$fields = array('password'=>$this->_createPasswordSALT($otherUserInfo['user_name'],$otherUserInfo['create_time'], $passwd)
					,'update_by'=>$userInfo['user_name']
					,'update_time'=>date("YmdHis", time())
				);
				$this->User_model->save($fields,array('user_id'=>$otherUserId));
				printAjaxSuccess('',"修改成功",$operFields,$this->Sys_oper_log_model);
			}else{
				printAjaxError('userId', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
			}
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}

	public function update_user_status(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/update_user_status',$jsonData);		
		if($jsonData ){
			$otherUserId = NULL;
			if(isset($jsonData->userId) && $jsonData->userId){
				$otherUserId = $jsonData->userId;
			}
			if($otherUserId){
				$otherUserInfo = $this->User_model->get("*",array('user_id'=>$otherUserId));
				if(!$otherUserInfo){
					printAjaxError('userInfo', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
				}
				$status = 0;
				if(isset($jsonData->status)){
					$status = $jsonData->status;
				}
				$fields = array('status'=>$status
					,'update_by'=>$userInfo['user_name']
					,'update_time'=>date("YmdHis", time())
				);
				$this->User_model->save($fields,array('user_id'=>$otherUserId));
				printAjaxSuccess('',"修改成功",$operFields,$this->Sys_oper_log_model);
			}else{
				printAjaxError('userId', '无效的用户信息',$operFields,$this->Sys_oper_log_model);
			}
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}

	private function delete_sys_user_by_id($userId,$username){
		$fields = array('del_flag'=>1,'update_by'=>$username,'update_time'=>date("YmdHis", time()));
		$this->User_model->save($fields,array('user_id'=>$userId));
	}
	public function delete_sys_user($userIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("user","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_user/delete_sys_user',$userIds);		
		if($userIds){
			$userIdsList = explode(',',$userIds);
			if(!empty($userIdsList)){
				foreach($userIdsList as $key=>$value){
					$this->delete_sys_user_by_id($value,$userInfo['user_name']);
				}
			}else{
				$this->delete_sys_user_by_id($userIds,$userInfo['user_name']);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}	

}
