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
class Sys_menu extends Controller
{
    private $User_model = NULL;
    private $Sys_menu_model = NULL;
    private $Sys_role_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
		$this->Sys_role_model = Helper::load_model("Sys_role",$this->db);
        $this->Sys_menu_model = Helper::load_model("Sys_menu",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
    
	public function get_menu_list($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}

		$whereStr = "(1=1)";
		//$jsonData = getJsonData();
		$pageNum = 1;
		$pageSize = 100000;
		if($jsonData){			
			if(isset($jsonData->status) && !empty($jsonData->status)){
				$whereStr = $whereStr." and status = ".trim($jsonData->status); 
			}			
			if(isset($jsonData->menuName) && !empty($jsonData->menuName)){
				$whereStr = $whereStr." and menu_name like '%".trim($jsonData->menuName)."%'"; 
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
			if(isset($jsonData->pageNum) && !empty($jsonData->pageNum)){
				$pageNum = trim($jsonData->pageNum);
			}
			if(isset($jsonData->pageSize) && !empty($jsonData->pageSize)){
				$pageSize = trim($jsonData->pageSize);
			}
		}
		$menus = $this->Sys_menu_model->gets2($whereStr,$pageSize,($pageNum - 1) * $pageSize);
		if($menus){
			foreach($menus as $key=>$value){
				$menus[$key]['menuId'] = intval($value['menuId']);
				$menus[$key]['orderNum'] = intval($value['orderNum']);
				$menus[$key]['parentId'] = intval($value['parentId']);
			}
		}
		printAjaxData($menus);
	}
	public function get_menu($menuId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		if($menuId){
			$menu = $this->Sys_menu_model->get("menu_id as menuId,menu_name as menuName,parent_id,parent_id as parentId,order_num,order_num as orderNum,path,component,is_frame as isFrame"
				.",menu_type as menuType,visible,perms,icon,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark"
				.",status",array('menu_id'=>$menuId));
				$menu['menuId'] = intval($menu['menuId']);
				$menu['orderNum'] = intval($menu['orderNum']);
				$menu['parentId'] = intval($menu['parentId']);
				printAjaxData($menu);
		}
		printAjaxError('menuId', '菜单id不能为空');
	}
	public function get_menu_list_by_roleId($roleId){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		if(!$roleId){
			printAjaxError('roleId', '角色信息错误');
		}
		$roleInfo = $this->Sys_role_model->get("*",array('role_id'=>$roleId));
		if(!$roleInfo){
			printAjaxError('roleInfo', '角色信息错误');
		}
		//if($_GET){
			
			$roleMenus = $this->Sys_menu_model->getsByRoleId($roleId,$roleInfo['menu_check_strictly']);
			$checkedKeys = array();
			if($roleMenus){
				foreach($roleMenus as $key=>$value){
					//$roleMenus[$key]['menuId'] = intval($value['menuId']);
					array_push($checkedKeys,intval($value['menuId']));
					// $menus[$key]['orderNum'] = intval($value['orderNum']);
					// $menus[$key]['parentId'] = intval($value['parentId']);
				}
			}

			$allMenus = $this->_get_menu_by_user($user_id);
			$menuTree = array();
			if(!empty($allMenus)){
				$menuTree = $this->getMenuTree($allMenus,0);
			}
			printAjaxRaw(array('checkedKeys'=>$checkedKeys,'menus'=>$menuTree));
		//}
	}
	public function update_menu(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$jsonData = getJsonData();
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("menu","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_menu/update_menu',$jsonData);			
		if($jsonData ){
			$menuId = NULL;
			if(isset($jsonData->menuId)){
				$menuId = $jsonData->menuId;
			}
			$fields = array('menu_name'=>$jsonData->menuName
			,'parent_id'=>$jsonData->parentId
			,'order_num'=>$jsonData->orderNum
			,'is_frame'=>$jsonData->isFrame
			,'menu_type'=>$jsonData->menuType
			,'visible'=>$jsonData->visible
			,'status'=>$jsonData->status);
			if(isset($jsonData->path)){
				$fields['path'] = $jsonData->path ? $jsonData->path : '#';
			}
			if(isset($jsonData->component)){
				$fields['component'] = $jsonData->component ? $jsonData->component : '';
			}
			if(isset($jsonData->icon)){
				$fields['icon'] = $jsonData->icon ? $jsonData->icon : '#';
			}
			if(isset($jsonData->remark)){
				$fields['remark'] = $jsonData->remark ? $jsonData->remark : '';
			}
			if(isset($jsonData->perms)){
				$fields['perms'] = $jsonData->perms ? $jsonData->perms : '';
			}
			if($menuId){
				$fields['update_by'] = $userInfo['user_name'];
				$fields['update_time'] = date("YmdHis", time());
			}else{
				$fields['create_by'] = $userInfo['user_name'];
				$fields['create_time'] = date("YmdHis", time());
			}
			$this->Sys_menu_model->save($fields,$menuId ? array('menu_id'=>$menuId) : NULL);
			printAjaxSuccess('',$menuId ? "修改成功" : "添加成功",$operFields,$this->Sys_oper_log_model);
		}
		printAjaxError('', '无效的请求',$operFields,$this->Sys_oper_log_model);
	}
	private function delete_menu_by_id($menuId){
		$this->Sys_menu_model->delete(array('menu_id'=>$menuId));
	}
	public function delete_menu($menuIds){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("menu","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'sys_menu/delete_menu',$menuIds);			
		if($menuIds){
			$menuIdsList = explode(',',$menuIds);
			if(!empty($menuIdsList)){
				foreach($menuIdsList as $key=>$value){
					$this->delete_menu_by_id($value);
				}
			}else{
				$this->delete_menu_by_id($menuIds);
			}
		}
		printAjaxSuccess("","删除成功",$operFields,$this->Sys_oper_log_model);
	}
	private function _get_menu_by_user($userId,$jsonData = NULL){
		if(_is_admin($userId)){
			$whereStr = '(1=1)';
			if($jsonData){
				if($jsonData->menuName){
					$whereStr .= " and menuName like '%".$jsonData->menuName."%'"; 
				}
				if($jsonData->visible){
					$whereStr .= " and visible = ".$jsonData->visible;
				}
				if($jsonData->status){
					$whereStr .= " and status = ".$jsonData->status;
				}
			}
			return $this->Sys_menu_model->gets2($whereStr,10000,0);
		}else{
			$whereStr = '';
			if($jsonData){
				if($jsonData->menuName){
					$whereStr .= " and m.menuName like '%".$jsonData->menuName."%'"; 
				}
				if($jsonData->visible){
					$whereStr .= " and m.visible = ".$jsonData->visible;
				}
				if($jsonData->status){
					$whereStr .= " and m.status = ".$jsonData->status;
				}
			}
			return $this->Sys_menu_model->getsByUserId($userId,$whereStr);
		}
	}
	public function getRouters(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$menus = $this->_get_menu_by_user($user_id);
		$menuTree = array();
		if(!empty($menus)){
			$menuTree = $this->getMenuTree($menus,0,NULL,'M',0);
		}
		printAjaxData($menuTree);
	}

	private function getRouterPath($menu,$parentMenu){
		if($parentMenu == NULL || $parentMenu['menuType'] == "G" && $menu['isFrame'] == "1"){
			return "/".$menu['path'];
		}
		return $menu['path'];
	}

	private function getMenuTree($menus,$parentId,$parentMenu = NULL,$menuType = NULL,$visile = -1){
		$menuList = array();
		foreach($menus as $key=>$value){
			if($visile != -1 && $value['visible'] != $visile){
				continue;
			}
			if($value['parentId'] == $parentId){
				$meta = array(
					"title"=>$value['menuName'],
					"icon"=>$value['icon']
				);
				$router = array(
					"name"=>ucfirst(strtolower($value['path'])),
					"path"=>$this->getRouterPath($value,$parentMenu),
					"component"=>empty($value['component']) ? "Layout" : $value['component'],
					"meta"=>$meta,
					'label'=>$value['menuName'],
					'id'=>intval($value['menuId'])
				);
				$children = $this->getMenuTree($menus,$value['menuId'],$value,$menuType,$visile);
				if(!empty($children) && sizeof($children) > 0){
					if($menuType == NULL || $menuType == $value['menuType']){
						$router['alwaysShow'] = true;
						$router['redirect'] = "noRedirect";
						$router['children'] = $children;
					}
				}
				array_push($menuList,$router);
			}
		}
		return $menuList;
	}

	public function select_menu_tree($jsonData){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		//$jsonData = getJsonData();
		$menus = $this->_get_menu_by_user($user_id,$jsonData);
		$menuTree = array();
		if($menus){
			$menuTree = $this->getMenuTree($menus,0);
		}
		printAjaxData($menuTree);
	}

}
