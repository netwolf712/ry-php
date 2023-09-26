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
class Sys_role extends Controller
{
    private $User_model = NULL;
    private $Sys_role_model = NULL;
	private $Sys_role_menu_model = NULL;
	private $Sys_role_dept_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
        $this->Sys_role_model = Helper::load_model("Sys_role",$this->db);
		$this->Sys_role_menu_model = Helper::load_model("Sys_role_menu",$this->db);
		$this->Sys_role_dept_model = Helper::load_model("Sys_role_dept",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
	public function get_role_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		$whereStr = "(1=1)";
		$pageNum = 1;
		$pageSize = 10;
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".$jsonData->status; 
			}
			if(isset($jsonData->roleName) && !empty($jsonData->roleName)){
				$whereStr = $whereStr." and role_name like '%".trim($jsonData->roleName)."%'"; 
			}
			if(isset($jsonData->roleKey) && !empty($jsonData->roleKey)){
				$whereStr = $whereStr." and role_key like '%".trim($jsonData->roleKey)."%'"; 
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
		$list = $this->Sys_role_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['roleId'] = intval($value['roleId']);
				$list[$key]['admin'] = ($value['roleKey'] == "admin") ? true : false;
				$list[$key]['flag'] = ($value['delFlag'] == "0") ? false : true;
				$list[$key]['menuCheckStrictly'] = $value['menuCheckStrictly'] ? true : false;
				$list[$key]['deptCheckStrictly'] = $value['deptCheckStrictly'] ? true : false;
			}
		}

		$count = $this->Sys_role_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}

	public function get_role($roleId){
		$data = $this->Sys_role_model->get("role_id as roleId,role_name as roleName,role_key as roleKey"
		.",role_sort as roleSort,data_scope as dataScope,del_flag as delFlag"
		.",menu_check_strictly as menuCheckStrictly"
		.",dept_check_strictly as deptCheckStrictly"
		.",status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark",
		array('role_id'=>$roleId));

		$data['roleId'] = intval($data['roleId']);
		$data['admin'] = ($data['roleKey'] == "admin") ? true : false;
		$data['flag'] = ($data['delFlag'] == "0") ? false : true;
		$data['menuCheckStrictly'] = $data['menuCheckStrictly'] ? true : false;
		$data['deptCheckStrictly'] = $data['deptCheckStrictly'] ? true : false;

		printAjaxData($data);
	}

	public function update_role_status(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("role","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_role/update_role_status',$jsonData);			
		if($jsonData && isset($jsonData->status) && isset($jsonData->roleId)){
			$this->Sys_role_model->save(array('status'=>$jsonData->status),array('role_id'=>$jsonData->roleId));
			printAjaxSuccess('',"修改成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}
	public function update_role(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("role","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_role/update_role',$jsonData);			
		$orgRoleId = NULL;
		if($jsonData ){
			$fields = array('role_name'=>$jsonData->roleName
			,'role_key'=>$jsonData->roleKey
			,'role_sort'=>$jsonData->roleSort
			,'data_scope'=>$jsonData->dataScope
			,'menu_check_strictly'=>$jsonData->menuCheckStrictly
			,'dept_check_strictly'=>$jsonData->deptCheckStrictly
			,'status'=>$jsonData->status);
			if(isset($jsonData->delFlag)){
				$fields['del_flag'] = $jsonData->delFlag;
			}
			if(isset($jsonData->remark)){
				$fields['remark'] = $jsonData->remark;
			}		
			if(isset($jsonData->roleId) && !empty($jsonData->roleId)){
				$orgRoleId = $jsonData->roleId;
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}

			$roleId = $this->Sys_role_model->save($fields,$orgRoleId ? array('role_id'=>$orgRoleId) : NULL);
			if($roleId){
				//如果是修改，则需先删除之前的菜单列表
				if($orgRoleId){
					$this->Sys_role_menu_model->delete(array('role_id'=>$orgRoleId));	
					$roleId = 	$orgRoleId;			
				}
				//添加菜单列表
				if(!empty($jsonData->menuIds)){
					foreach($jsonData->menuIds as $key=>$value){
						$this->Sys_role_menu_model->save(array('role_id'=>$roleId,'menu_id'=>$value));
					}
				}
			}
			printAjaxSuccess('',$orgRoleId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}
		printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
	}
	public function update_role_data_scope(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("role","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_role/update_role_data_scope',$jsonData);		
		if($jsonData && isset($jsonData->roleId)){
			if(!$jsonData->roleId){
				printAjaxError('roleId', '无效的角色信息',$operFields,$this->Sys_oper_log_model);
			}
			$fields = array('data_scope'=>$jsonData->dataScope
			,'update_by'=>$userInfo['user_name']
			,'update_time'=>date("YmdHis", time()));
			$fields['dept_check_strictly'] = $jsonData->deptCheckStrictly;
			$fields['menu_check_strictly'] = $jsonData->menuCheckStrictly;
			$this->Sys_role_model->save($fields,array('role_id'=>$jsonData->roleId));
			//更新sys_role_dept表
			$this->Sys_role_dept_model->delete(array('role_id'=>$jsonData->roleId));
			if(isset($jsonData->deptIds)){
				foreach($jsonData->deptIds as $key=>$value){
					$this->Sys_role_dept_model->save(array('role_id'=>$jsonData->roleId,'dept_id'=>$value));
				}
			}
			printAjaxSuccess('',"修改成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
		}
	}
	private function delete_role_by_id($roleId){
		$this->Sys_role_model->delete(array('role_id'=>$roleId));
	}
	public function delete_role($roleIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("role","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_role/delete_role',$roleIds);		
		if($roleIds){
			$roleIdsList = explode(',',$roleIds);
			if(!empty($roleIdsList)){
				foreach($roleIdsList as $key=>$value){
					$this->delete_role_by_id($value);
				}
			}else{
				$this->delete_role_by_id($roleIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}		
}
