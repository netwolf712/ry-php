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
class Sys_oper_log extends Controller
{
    private $Sys_oper_log_model = NULL;

    public function __construct($params) {
		parent::__construct($params);
        $this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
	public function get_oper_log_list($jsonData){
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
			if(isset($jsonData->title) && !empty($jsonData->title)){
				$whereStr = $whereStr." and title like '%".trim($jsonData->title)."%'"; 
			}
			if(isset($jsonData->operName) && !empty($jsonData->operName)){
				$whereStr = $whereStr." and oper_name like '%".trim($jsonData->operName)."%'"; 
			}
			if(isset($jsonData->businessType) && !empty($jsonData->businessType)){
				$whereStr = $whereStr." and business_type = ".$jsonData->businessType; 
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
		$list = $this->Sys_oper_log_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['operId'] = intval($value['operId']);
			}
		}

		$count = $this->Sys_oper_log_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}

	public function get_oper_log($operId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_oper_log_model->get2(array('oper_id'=>$operId));
		printAjaxData($data);
	}

	private function delete_oper_log_by_id($operId){
		$this->Sys_oper_log_model->delete(array('oper_id'=>$operId));
	}
	public function delete_oper_log($operIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		if($operIds){
			$operIdsList = explode(',',$operIds);
			if(!empty($operIdsList)){
				foreach($operIdsList as $key=>$value){
					$this->delete_oper_log_by_id($value);
				}
			}else{
				$this->delete_oper_log_by_id($operIds);
			}
		}
		printAjaxSuccess("","删除成功");
	}	

	public function clear_oper_log(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$this->Sys_oper_log_model->clearAll();
		printAjaxSuccess("","清除成功");
	}
}
