<?php
class Sys_dept_model extends Model {

	private $_deptVo = "dept_id as deptId,parent_id as parentId,ancestors,dept_name as deptName,order_num as orderNum"
						.",leader,phone,email,del_flag as delFlag"
						.",status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime";



    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"role_sort","asc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($this->_deptVo,$strWhere,$limit,$offset,"order_num","asc");
	}

    public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select($this->_deptVo);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

	/**
	 * 检查部门名称的唯一性
	 */
	public function checkDeptNameUnique($deptName,$parentId){
		$ret = array();
		$queryStr = "select {$this->_deptVo} from {$this->_tableName}  where dept_name LIKE '".$deptName."' and parent_id = {$parentId} and del_flag = '0' order by {$this->_tableName}.order_num asc limit 1 ";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			return $ret[0];
		}

		return NULL;
	}

	/**
	 * 获取此节点下正常的节点数量
	 */
	public function selectNormalChildrenDeptById($deptId){
		$count = 0;
		$query = $this->db->query("select count(*) as count from sys_dept where status = 0 and del_flag = '0' and find_in_set({$deptId}, ancestors)");
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

	/**
	 * 获取子节点
	 */
	public function selectChildrenDeptById($deptId){
		$ret = array();
		if(!$strWhere) return $ret;
		$queryStr = "select {$this->_deptVo} from {$this->_tableName}  where find_in_set({$deptId}, ancestors) ";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}
		return $ret;
	}

	/**
	 * 更新所有父节点的状态
	 */
	public function updateParentDeptStatus($status,$ancestors){
		$queryStr = "update {$this->_tableName} set status = {$status} where dept_id in ({$ancestors}) ";
		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * 是否存在下级部门
	 */
	public function hasChildByDeptId($deptId){
		$count = 0;
		$query = $this->db->query("select count(1) as count from sys_dept
		where del_flag = '0' and parent_id = {$deptId} limit 1");
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

	/**
	 * 检查部门是否存在人员
	 */
	public function checkDeptExistUser($deptId){
		$count = 0;
		$query = $this->db->query("select count(1) as count from sys_user_dept where dept_id = {$deptId}");
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

	public function selectDeptByUserId($userId){
		$ret = array();
		$queryStr = "select d.dept_id
        from sys_dept d
	        left join sys_user_dept ud on ud.dept_id = d.dept_id
	        left join sys_user u on u.user_id = ud.user_id
	    where u.user_id = {$userId}";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */