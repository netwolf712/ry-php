<?php
class Sys_user_dept_model extends Model {

	private $_deptUserVo = "select ud.user_dept_id as userDeptId, ud.user_id as userId,ud.dept_id as deptId
	,d.dept_name as deptName 
	from sys_user_dept ud 
	left join sys_dept d on d.dept_id = ud.dept_id";


    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"user_id","asc");
	}
	public function gets2($select = '*', $strWhere = NULL)
	{
		return $this->_gets2($select,$strWhere);
	}

	public function gets3($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		$ret = array();
		if(!$strWhere) return $ret;
		$queryStr = "{$this->_deptUserVo}  where {$strWhere} order by ud.user_id asc limit {$limit} offset {$offset} ";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function rowCount3($strWhere = NULL) {
		$count = 0;
		$query = $this->db->query("select count(*) as 'count' from sys_user_dept ud 
		left join sys_dept d on d.dept_id = ud.dept_id where {$strWhere}");
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */