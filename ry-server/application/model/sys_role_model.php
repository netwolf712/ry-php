<?php
class Sys_role_model extends Model {

	private $_roleVo = "select distinct r.role_id as roleId, r.role_name as roleName, r.role_key as roleKey, r.role_sort as roleSort
						, r.data_scope as dataScope, r.menu_check_strictly as menuCheckStrictly, r.dept_check_strictly as deptCheckStrictly,
						r.status, r.del_flag as delFlag, r.create_time as createTime, r.remark 
						from sys_role r
						left join sys_user_role ur on ur.role_id = r.role_id
						left join sys_user u on u.user_id = ur.user_id";

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"role_sort","asc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		$select = "role_id as roleId,role_name as roleName,role_key as roleKey"
		.",role_sort as roleSort,data_scope as dataScope,del_flag as delFlag"
		.",menu_check_strictly as menuCheckStrictly"
		.",dept_check_strictly as deptCheckStrictly"
		.",status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark";
		return $this->_gets2($select,$strWhere,$limit,$offset,"role_sort","asc");
	}
	public function selectRolePermissionByUserId($userId){
		$ret = array();
		$queryStr = "{$this->_roleVo} where r.del_flag = '0' and ur.user_id = {$userId}";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */