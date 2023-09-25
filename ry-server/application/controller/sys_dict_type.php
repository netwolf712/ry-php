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
class Sys_dict_type extends Controller
{
    private $User_model = NULL;
    private $Sys_dict_type_model = NULL;
	private $Sys_dict_data_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
		$this->Sys_dict_data_model = Helper::load_model("Sys_dict_data",$this->db);
        $this->Sys_dict_type_model = Helper::load_model("Sys_dict_type",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
	public function get_dict_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		//if($jsonData){
		$whereStr = "(1=1)";
		$pageNum = 1;
		$pageSize = 10;
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".trim($jsonData->status); 
			}
			if(isset($jsonData->dictName) && !empty($jsonData->dictName)){
				$whereStr = $whereStr." and dict_name like '%".trim($jsonData->dictName)."%'"; 
			}
			if(isset($jsonData->dictType) && !empty($jsonData->dictType)){
				$whereStr = $whereStr." and dict_type like '%".trim($jsonData->dictType)."%'"; 
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
				$pageNum = trim($jsonData->pageNum);
			}
			if(isset($jsonData->pageSize) && $jsonData->pageSize){
				$pageSize = trim($jsonData->pageSize);;
			}
		}
		$list = $this->Sys_dict_type_model->gets2("dict_id as dictId,dict_name as dictName,dict_type as dictType"
			.",status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark",$whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
				foreach($list as $key=>$value){
					$list[$key]['dictId'] = intval($value['dictId']);
				}
		}

		$count = $this->Sys_dict_type_model->rowCount2($whereStr);
		printAjaxList($list,$count ? $count : 0);
		// }else{
		// 	printAjaxError("","无效的请求");
		// }
	}

	public function get_dict_type($typeId){
		$dictType = $this->Sys_dict_type_model->get("dict_id as dictId,dict_name as dictName,dict_type as dictType,status,create_by as createBy,"
		."create_time as createTime,update_by as updateBy,update_time as updateTime,remark",array('dict_id'=>$typeId));
		printAjaxData($dictType);
	}

	private function delete_dict_type_by_id($typeId){
		$dictTypeInfo = $this->Sys_dict_type_model->get("*",array('dict_id'=>$typeId));
		if($dictTypeInfo){
			$this->Sys_dict_data_model->delete(array('dict_type'=>$dictTypeInfo['dict_type']));
		}
		$this->Sys_dict_type_model->delete(array('dict_id'=>$typeId));
	}
	public function delete_dict_type($typeIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dict","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dict_type/delete_dict_type',$typeIds);			
		if($typeIds){
			$typeIdList = explode(',',$typeIds);
			if(!empty($typeIdList)){
				foreach($typeIdList as $key=>$value){
					$this->delete_dict_type_by_id($value);
				}
			}else{
				$this->delete_dict_type_by_id($typeIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}

	public function update_dict_type(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dict","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dict_type/update_dict_type',$jsonData);			
		$dictId = NULL;
		if($jsonData ){
			$fields = array('dict_name'=>$jsonData->dictName
			,'dict_type'=>$jsonData->dictType
			,'remark'=>$jsonData->remark
			,'status'=>$jsonData->status);
			if(isset($jsonData->dictId) && $jsonData->dictId){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
				$dictId = $jsonData->dictId;
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}
			$this->Sys_dict_type_model->save($fields,$dictId ? array('dict_id'=>$dictId) : NULL);
			printAjaxSuccess('',$dictId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}
	public function get_dict_data_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$pageNum = 1;
		$pageSize = 10;
		$whereStr = "(1=1)";
		//$jsonData = getJsonData();
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".trim($jsonData->status); 
			}
			if(isset($jsonData->dictLabel) && !empty($jsonData->dictLabel)){
				$whereStr = $whereStr." and dict_label like '%".trim($jsonData->dictLabel)."%'"; 
			}
			if(isset($jsonData->dictType) && !empty($jsonData->dictType)){
				$whereStr = $whereStr." and dict_type like '%".trim($jsonData->dictType)."%'"; 
			}
			if(isset($jsonData->pageNum) && $jsonData->pageNum){
				$pageNum = trim($jsonData->pageNum);
			}
			if(isset($jsonData->pageSize) && $jsonData->pageSize){
				$pageSize = trim($jsonData->pageSize);
			}
		}
		$dataList = $this->Sys_dict_data_model->gets2("dict_code as dictCode,dict_value as dictValue,dict_sort as dictSort,dict_label as dictLabel,dict_type as dictType,css_class as cssClass"
		.",list_class as listClass,is_default as isDefault,status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark",$whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($dataList)){
			foreach($dataList as $key=>$value){
				if($value['isDefault'] == 'Y'){
					$dataList[$key]['default'] = true;
				}else{
					$dataList[$key]['default'] = false;
				}
				//$dataList[$key]['dictValue'] = intval($dictTypeData['dict_id']);
				$dataList[$key]['dictCode'] = intval($value['dictCode']);
				$dataList[$key]['dictSort'] = intval($value['dictSort']);
			}
		}

		$count = $this->Sys_dict_data_model->rowCount2($whereStr);
		printAjaxList($dataList,$count ? $count : 0);
	}

	/**
	 * 获取字典内容
	 * 没有则创建一个
	 */
	private function _get_dict_data($operator,$dictType,$dictLabel){
		if(is_numeric($dictLabel)){
			//如果是数值，则还需判断dict_value是否存在
			$dictData = $this->Sys_dict_data_model->get("*",array('dict_type'=>$dictType,'dict_value'=>$dictLabel));
			if($dictData){
				return $dictData;
			}
		}else{
			//如果不是数字，则从label查找
			$dictData = $this->Sys_dict_data_model->get("*",array('dict_type'=>$dictType,'dict_label'=>$dictLabel));
			if($dictData){
				return $dictData;
			}
		}

		//如果都没找到，则创建一个
		$maxValue = $this->Sys_dict_data_model->getMaxDictValue(array('dict_type'=>$dictType));
		$fields = array('dict_type'=>$dictType
						,'dict_value'=>intval($maxValue) + 1
						,'dict_label'=>$dictLabel
						,'create_by'=>$operator
						,'create_time'=>date("YmdHis", time()));
		$dictCode = $this->Sys_dict_data_model->save($fields);
		$fields['dictCode'] = $dictCode;
		return $fields;
	}
	public function update_dict_data(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dict","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dict_type/update_dict_data',$jsonData);		
		$dictCode = NULL;
		if($jsonData ){
			$fields = array('dict_sort'=>$jsonData->dictSort
			,'dict_label'=>$jsonData->dictLabel
			,'dict_value'=>$jsonData->dictValue
			,'dict_type'=>$jsonData->dictType
			,'css_class'=>$jsonData->cssClass
			,'list_class'=>$jsonData->listClass
			,'is_default'=>$jsonData->isDefault
			,'remark'=>$jsonData->remark
			,'status'=>$jsonData->status);
			if(isset($jsonData->dictCode) && $jsonData->dictCode){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
				$dictCode = $jsonData->dictCode;
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}
			$this->Sys_dict_data_model->save($fields,$dictCode ? array('dict_code'=>$dictCode) : NULL);
			printAjaxSuccess('',$dictCode ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}		
	}
	
	public function get_dict_data($dictCode){
		$dataList = $this->Sys_dict_data_model->get("dict_code as dictCode,dict_sort as dictSort,dict_label as dictLabel,dict_type as dictType,css_class as cssClass"
		.",list_class as listClass,is_default as isDefault,status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark,dict_value as dictValue",
		array('dict_code'=>$dictCode));
		printAjaxData($dataList);
	}

	public function get_dict_data_by_type($dictType){
		//$dictTypeData = $this->Sys_dict_type_model->get("*",array('dict_type'=>$dictType));
		$dataList = $this->Sys_dict_data_model->gets("dict_code as dictCode,dict_sort as dictSort,dict_label as dictLabel,dict_type as dictType,css_class as cssClass"
		.",list_class as listClass,is_default as isDefault,status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark"
		.",dict_value as dictValue",
		array('dict_type'=>$dictType));
		if(!empty($dataList)){
			foreach($dataList as $key=>$value){
				if($value['isDefault'] == 'Y'){
					$dataList[$key]['default'] = true;
				}else{
					$dataList[$key]['default'] = false;
				}
				//$dataList[$key]['dictValue'] = intval($dictTypeData['dict_id']);
				$dataList[$key]['dictCode'] = intval($value['dictCode']);
				$dataList[$key]['dictSort'] = intval($value['dictSort']);
			}
		}
		printAjaxData($dataList);
	}
	private function delete_dict_data_by_code($dictCode){
		$this->Sys_dict_data_model->delete(array('dict_code'=>$dictCode));
	}
	public function delete_dict_data($dictCodes){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dict","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dict_type/delete_dict_data',$dictCodes);		
		if($dictCodes){
			$dictCodesList = explode(',',$dictCodes);
			if(!empty($dictCodesList)){
				foreach($dictCodesList as $key=>$value){
					$this->delete_dict_data_by_code($value);
				}
			}else{
				$this->delete_dict_data_by_code($dictCodes);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}
}
