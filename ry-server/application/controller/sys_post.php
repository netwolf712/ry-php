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
class Sys_post extends Controller
{
    private $User_model = NULL;
    private $Sys_post_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
        $this->Sys_post_model = Helper::load_model("Sys_post",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
	public function get_post_list($jsonData){
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
			if(isset($jsonData->postName) && !empty($jsonData->postName)){
				$whereStr = $whereStr." and post_name like '%".trim($jsonData->postName)."%'"; 
			}
			if(isset($jsonData->postCode) && !empty($jsonData->postCode)){
				$whereStr = $whereStr." and post_code like '%".trim($jsonData->postCode)."%'"; 
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
		$list = $this->Sys_post_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['postId'] = intval($value['postId']);
			}
		}

		$count = $this->Sys_post_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);		
	}

	public function get_post($postId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_post_model->get2(array('post_id'=>$postId));
		printAjaxData($data);
	}

	public function update_post(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("post","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_post/update_post',$jsonData);			
		if($jsonData ){
			$orgPostId = NULL;
			$fields = array('post_code'=>$jsonData->postCode
			,'post_name'=>$jsonData->postName
			,'post_sort'=>$jsonData->postSort
			,'status'=>$jsonData->status
			,'remark'=>$jsonData->remark);
			if(isset($jsonData->postId) && $jsonData->postId){
				$orgPostId = $jsonData->postId;
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}
			$postId = $this->Sys_post_model->save($fields,$orgPostId ? array('post_id'=>$orgPostId) : NULL);
			printAjaxSuccess('',$orgPostId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}
	
	private function delete_post_by_id($postId){
		$this->Sys_post_model->delete(array('post_id'=>$postId));
	}
	public function delete_post($postIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("post","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_post/delete_post',$postIds);		
		if($postIds){
			$postIdsList = explode(',',$postIds);
			if(!empty($postIdsList)){
				foreach($postIdsList as $key=>$value){
					$this->delete_post_by_id($value);
				}
			}else{
				$this->delete_post_by_id($postIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model );
	}	
}
