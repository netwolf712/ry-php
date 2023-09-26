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
class Sys_dept extends Controller
{
    private $User_model = NULL;
    private $Sys_dept_model = NULL;
	private $Sys_role_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
        $this->Sys_dept_model = Helper::load_model("Sys_dept",$this->db);
		$this->Sys_role_model = Helper::load_model("Sys_role",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
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
	public function get_dept_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		$whereStr = "del_flag = 0";
		if($jsonData){			
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".$jsonData->status; 
			}
			if(isset($jsonData->deptName) && !empty($jsonData->deptName)){
				$whereStr = $whereStr." and dept_name like '%".trim($jsonData->deptName)."%'"; 
			}
			if(isset($jsonData->leader) && !empty($jsonData->leader)){
				$whereStr = $whereStr." and leader like '%".trim($jsonData->leader)."%'"; 
			}
			if(isset($jsonData->phone) && !empty($jsonData->phone)){
				$whereStr = $whereStr." and phone like '%".trim($jsonData->phone)."%'"; 
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
		}
		//增加权限范围判断
		$dataScopeWhere = $this->_get_dept_data_scope($user_id);
		if(strlen($dataScopeWhere) > 0){
			$whereStr .= (" and (".$dataScopeWhere." ) ");
		}
		$pageNum = 1;
		$pageSize = 100000;
		$list = $this->Sys_dept_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['deptId'] = intval($value['deptId']);
			}
		}

		//$count = $this->Sys_dept_model->rowCount2($whereStr);
		printAjaxData($list);		
	}

	public function get_dept($deptId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$data = $this->Sys_dept_model->get2(array('dept_id'=>$deptId));
		printAjaxData($data);
	}

	/**
	 * 查找是否在祖先里
	 */
	private function _in_ancestors($ancestors,$deptId){
		if(stripos($ancestors,$deptId.",") != false || stripos($ancestors,",".$deptId) != false){
			return true;
		}
		return false;
	}
	/**
	 * 获取非此节点且不是此节点的子节点的节点
	 */
	public function get_exclude_dept($deptId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$excludeList = array();
		$list = $this->Sys_dept_model->gets2("del_flag = 0",100000,0);
		if(!empty($list)){
			foreach($list as $key=>$value){
				if($value['deptId'] != $deptId && !$this->_in_ancestors($value['ancestors'],$deptId)){
					$value['deptId'] = intval($value['deptId']);
					array_push($excludeList,$value);
				}
			}
		}
		printAjaxData($excludeList);
	}
	/**
	 * 检查单位名称的唯一性
	 * @return true 唯一（可添加）false 不唯一，不可添加
	 */
	private function check_dept_name_unique($jsonData){
		$deptId = isset($jsonData->deptId) ? $jsonData->deptId : -1;
		$info = $this->Sys_dept_model->checkDeptNameUnique($jsonData->deptName,$jsonData->parentId);
		if($info && $info['deptId'] != $deptId){
			return false;
		}
		return true;
	}
	public function update_dept(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dept","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dept/update_dept',$jsonData);		
		if($jsonData ){
			$deptId = NULL;			
			if(isset($jsonData->deptId)){
				$deptId = $jsonData->deptId;
			}
			//检查名字是否重复
			if(!$this->check_dept_name_unique($jsonData)){
				printAjaxError('deptName', '失败，单位名称已存在',$operFields,$this->Sys_oper_log_model);
			}
			if($deptId){
				if($deptId == $jsonData->parentId){
					printAjaxError('parentId', '失败，上级单位不能是自己',$operFields,$this->Sys_oper_log_model);
				}
				if($jsonData->status == 1 && $this->Sys_dept_model->selectNormalChildrenDeptById($deptId)){
					//如果是停用，则要判断所有子节点是否在不可用状态
					printAjaxError('status', '该单位包含未停用的子单位！',$operFields,$this->Sys_oper_log_model);
				}
			}
			$parentDept = $this->Sys_dept_model->get2(array('dept_id'=>$jsonData->parentId));
			if(!$deptId && $parentDept['status'] == 1){
				//如果是新增，且父节点为不正常状态，则不允许增加
				printAjaxError('status', '单位停用，不允许新增',$operFields,$this->Sys_oper_log_model);
			}
			$fields = array('parent_id'=>$jsonData->parentId
			,'ancestors'=>$jsonData->ancestors
			,'dept_name'=>$jsonData->deptName			
			,'status'=>$jsonData->status
			,'order_num'=>$jsonData->orderNum);

			if(isset($jsonData->leader)){
				$fields['leader'] = $jsonData->leader;
			}
			if(isset($jsonData->phone)){
				$fields['phone'] = $jsonData->phone;
			}	
			if(isset($jsonData->email)){
				$fields['email'] = $jsonData->email;
			}					
			if($deptId){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());

				//如果是修改，则获取此节点的原始信息
				$oldDept = $this->Sys_dept_model->get2(array('dept_id'=>$deptId));
				if($parentDept && $oldDept && $oldDept['parentId'] != $jsonData->parentId){
					//如果父节点改变，则更新所有子节点的祖先
					$children = $this->Sys_dept_model->selectChildrenDeptById($deptId);
					if(!empty($children)){
						$newAncestors = $parentDept['ancestors'].",".$parentDept['deptId'];
						foreach($children as $key=>$value){
							$ancestors = str_replace($oldDept['ancestors'],$newAncestors,$value['ancestors']);
							$tmpField = array('ancestors'=>$ancestors);
							$tmpField['update_by'] = $userInfo['user_name'];
							$tmpField['update_time'] = date("YmdHis", time());
							$this->Sys_dept_model->save($tmpField,array('dept_id'=>$value['deptId']));
						}
					}
				}
				//如果是启用，则将所有的父节点都更新为启用
				if($jsonData->status == 0 && isset($jsonData->ancestors) && $jsonData->ancestors != 0){
					$this->Sys_dept_model->updateParentDeptStatus($jsonData->status,$jsonData->ancestors);
				}
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
				//如果是新增，则增加祖先字段
				$fields['ancestors'] = $parentDept['ancestors'].",".$jsonData->parentId;
			}
			$this->Sys_dept_model->save($fields,$deptId ? array('dept_id'=>$deptId) : NULL);
			printAjaxSuccess('',$deptId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError("","无效的请求",$operFields,$this->Sys_oper_log_model);
		}
	}
	
	private function delete_dept_by_id($deptId){
		if($this->Sys_dept_model->hasChildByDeptId($deptId)){
			printAjaxError('delete', '存在下级单位,不允许删除');
		}
		if($this->Sys_dept_model->checkDeptExistUser($deptId)){
			printAjaxError('delete', '单位存在用户,不允许删除');
		}
		$this->Sys_dept_model->delete(array('dept_id'=>$deptId));
	}
	public function delete_dept($deptIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("dept","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_dept/delete_dept',$deptIds);		
		if($deptIds){
			$deptIdsList = explode(',',$deptIds);
			if(!empty($deptIdsList)){
				foreach($deptIdsList as $key=>$value){
					$this->delete_dept_by_id($value);
				}
			}else{
				$this->delete_dept_by_id($deptIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}	

	private function _get_dept_tree($deptList,$parentId){
		$children = array();
		if(!empty($deptList)){
			foreach($deptList as $key=>$value){
				if($value['parentId'] == $parentId){
					$dept = array('id'=>intval($value['deptId'])
					,'label'=>$value['deptName']);
					$subChildren = $this->_get_dept_tree($deptList,$value['deptId']);
					if(!empty($subChildren)){
						$dept['children'] = $subChildren;
					}
					array_push($children,$dept);
				}
			}
		}
		return $children;
	}

	private function _select_dept_tree($jsonData,$user_id){
		$whereStr = "del_flag = 0";
		//$jsonData = getJsonData();
		if($jsonData){
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".$jsonData->status; 
			}
			if(isset($jsonData->deptName) && !empty($jsonData->deptName)){
				$whereStr = $whereStr." and dept_name like '%".trim($jsonData->deptName)."%'"; 
			}
			if(isset($jsonData->deptId) && !empty($jsonData->deptId)){
				$whereStr = $whereStr." and dept_id = {$jsonData->deptId}"; 
			}
		}
		//增加权限范围判断
		$dataScopeWhere = $this->_get_dept_data_scope($user_id);
		if(strlen($dataScopeWhere) > 0){
			$whereStr .= (" and (".$dataScopeWhere." ) ");
		}
		$pageNum = 1;
		$pageSize = 100000;
		$list = $this->Sys_dept_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['deptId'] = intval($value['deptId']);
			}
		}
		return $this->_get_dept_tree($list,100);
	}
	public function select_dept_tree($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		printAjaxData($this->_select_dept_tree($jsonData,$user_id));
	}

	public function get_dept_tree_by_role_id($roleId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		if(!$roleId){
			printAjaxError('roleId', '角色id不能为空');
		}
		$deptTree = $this->_select_dept_tree(NULL,$user_id);
		$role = $this->Sys_role_model->get("*",array('role_id'=>$roleId));
		if(!$role){
			printAjaxError('role', '无效的角色信息');
		}
		$whereStr = "del_flag = 0 and dept_id in (select dept_id from sys_role_dept where role_id = {$roleId})";
		if($role["dept_check_strictly"]){
			$whereStr .= " and dept_id not in (select d.parent_id from sys_dept d inner join sys_role_dept rd on d.dept_id = rd.dept_id and rd.role_id = {$roleId})";
		}
		$checkedDepts = $this->Sys_dept_model->gets2($whereStr,1000000,0);
		$checkedKeys = array();
		if($checkedDepts){
			foreach($checkedDepts as $key=>$value){
				array_push($checkedKeys,intval($value['deptId']));
			}
		}
		printAjaxRaw(array('checkedKeys'=>$checkedKeys,'depts'=>$deptTree));
	}
}
