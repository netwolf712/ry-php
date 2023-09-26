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
class Sys_login_info extends Controller
{
    private $Sys_login_info_model = NULL;

    public function __construct($params) {
		parent::__construct($params);
        $this->Sys_login_info_model = Helper::load_model("Sys_login_info",$this->db);
    }
	public function get_login_info_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$whereStr = "(1=1)";
		$pageNum = 1;
		$pageSize = 10;		
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".$jsonData->status; 
			}
			if(isset($jsonData->userName) && !empty($jsonData->userName)){
				$whereStr = $whereStr." and user_name like '%".trim($jsonData->userName)."%'"; 
			}
			if(isset($jsonData->ipaddr) && !empty($jsonData->ipaddr)){
				$whereStr = $whereStr." and ipaddr like '%".trim($jsonData->ipaddr)."%'"; 
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
		$list = $this->Sys_login_info_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['infoId'] = intval($value['infoId']);
			}
		}

		$count = $this->Sys_login_info_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}

	public function get_login_info($infoId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_login_info_model->get2(array('info_id'=>$infoId));
		printAjaxData($data);
	}
	
	private function delete_login_info_by_id($infoId){
		$this->Sys_login_info_model->delete(array('info_id'=>$infoId));
	}
	public function delete_login_info($infoIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		if($infoIds){
			$infoIdsList = explode(',',$infoIds);
			if(!empty($infoIdsList)){
				foreach($infoIdsList as $key=>$value){
					$this->delete_login_info_by_id($value);
				}
			}else{
				$this->delete_login_info_by_id($infoIds);
			}
		}
		printAjaxSuccess("","删除成功");
	}	

	public function clear_login_info(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$this->Sys_login_info_model->clearAll();
		printAjaxSuccess("","清除成功");
	}
}
