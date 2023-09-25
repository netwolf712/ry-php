<?php
class Sys_login_info_model extends Model {

	private $_loginInfoVo = "info_id as infoId,user_name as userName,ipaddr,login_location as loginLocation,browser,os,status,msg,login_time as loginTime";
    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"login_time","desc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($this->_loginInfoVo,$strWhere,$limit,$offset,"login_time","desc");
	}
	public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select($this->_loginInfoVo);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

	public function clearAll(){
		$query = $this->db->query("delete from {$this->_tableName}");
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */