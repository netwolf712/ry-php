<?php
class Sys_menu_model extends Model {

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select($select);		
		$this->db->order_by("{$this->_tableName}.parent_id", 'asc');
		$this->db->order_by("{$this->_tableName}.order_num", 'asc');
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
	    if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		$ret = array();
		if(!$strWhere) return $ret;
		$select = "menu_id as menuId,menu_name as menuName,parent_id,parent_id as parentId,order_num,order_num as orderNum,path,component,is_frame as isFrame"
		.",menu_type as menuType,visible,perms,icon,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark"
		.",status";
		$queryStr = "select {$select} from {$this->_tableName}  where {$strWhere} order by {$this->_tableName}.parent_id asc,{$this->_tableName}.order_num asc limit {$limit} offset {$offset} ";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function getsByRoleId($roleId,$menuCheckStrictly)
	{
		$ret = array();
		$queryStr = "select m.menu_id as menuId from {$this->_tableName} as m "
		." left join sys_role_menu rm on m.menu_id = rm.menu_id"
		." where rm.role_id = {$roleId}"; 
		if($menuCheckStrictly){
			$queryStr .= " and m.menu_id not in (select m.parent_id from sys_menu m inner join sys_role_menu rm on m.menu_id = rm.menu_id and rm.role_id = {$roleId})";
		}
		$queryStr .= " order by m.parent_id asc,m.order_num asc";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function getsByUserId($userId,$whereStr = ''){
		$ret = array();
		$queryStr = "select distinct m.menu_id as menuId, m.parent_id as parentId, m.menu_name as menuName, m.path, m.component, m.visible, m.status, ifnull(m.perms,'') as perms, m.is_frame as isFrame, m.menu_type as menuType, m.icon, m.order_num as orderNum, m.create_time as createTime
		from sys_menu m
		left join sys_role_menu rm on m.menu_id = rm.menu_id
		left join sys_user_role ur on rm.role_id = ur.role_id
		left join sys_role ro on ur.role_id = ro.role_id
		where ur.user_id = {$userId} {$whereStr}
		order by m.parent_id, m.order_num";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function selectMenuPermsByUserId($userId){
		$ret = array();
		$queryStr = "select distinct m.perms
		from sys_menu m
			 left join sys_role_menu rm on m.menu_id = rm.menu_id
			 left join sys_user_role ur on rm.role_id = ur.role_id
			 left join sys_role r on r.role_id = ur.role_id
		where m.status = '0' and r.status = '0' and ur.user_id = {$userId}";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */