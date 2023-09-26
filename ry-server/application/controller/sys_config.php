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
class Sys_config extends Controller
{
    private $User_model = NULL;
    private $Sys_config_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
        $this->Sys_config_model = Helper::load_model("Sys_config",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
	public function get_config_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		$whereStr = "(1=1)";
		$pageNum = 1;
		$pageSize = 10;		
		if($jsonData){
			if(isset($jsonData->configName) && !empty($jsonData->configName)){
				$whereStr = $whereStr." and config_name like '%".trim($jsonData->configName)."%'"; 
			}
			if(isset($jsonData->configKey) && !empty($jsonData->configKey)){
				$whereStr = $whereStr." and config_key like '%".trim($jsonData->configKey)."%'"; 
			}
			if(isset($jsonData->configType) && !empty($jsonData->configType)){
				$whereStr = $whereStr." and config_type like '%".trim($jsonData->configType)."%'"; 
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
		$list = $this->Sys_config_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['configId'] = intval($value['configId']);
			}
		}

		$count = $this->Sys_config_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}

	public function get_config($configId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_config_model->get2(array('config_id'=>$configId));
		printAjaxData($data);
	}

	public function get_config_by_key($configKey){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_config_model->get2(array('config_key'=>$configKey));
		printAjaxData($data);
	}

	public function update_config(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("config","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_config/update_config',$jsonData);			
		if($jsonData ){
			$orgConfigId = NULL;
			$fields = array('config_name'=>$jsonData->configName
			,'config_key'=>$jsonData->configKey
			,'config_value'=>$jsonData->configValue
			,'config_type'=>$jsonData->configType
			,'remark'=>$jsonData->remark);
			if(isset($jsonData->configId) && $jsonData->configId){
				$orgConfigId = $jsonData->configId;
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}
			$configId = $this->Sys_config_model->save($fields,$orgConfigId ? array('config_id'=>$orgConfigId) : NULL);
			printAjaxSuccess('',$orgConfigId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}
	
	private function delete_config_by_id($configId){
		$this->Sys_config_model->delete(array('config_id'=>$configId));
	}
	public function delete_config($configIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("config","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_config/delete_config',$configIds);		
		if($configIds){
			$configIdsList = explode(',',$configIds);
			if(!empty($configIdsList)){
				foreach($configIdsList as $key=>$value){
					$this->delete_config_by_id($value);
				}
			}else{
				$this->delete_config_by_id($configIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model );
	}	
}
