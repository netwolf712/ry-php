<?php
class Sys_oper_log_model extends Model {

	private $_operLogVo = "oper_id as operId
		,title
		,business_type as businessType
		,method
		,request_method as requestMethod
		,operator_type as operatorType
		,oper_name as operName
		,dept_name as deptName
		,oper_url as operUrl
		,oper_ip as operIp
		,oper_location as operLocation
		,oper_param as operParam
		,json_result as jsonResult
		,status
		,error_msg as errorMsg
		,oper_time as operTime";
    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"oper_time","desc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($this->_operLogVo,$strWhere,$limit,$offset,"oper_time","desc");
	}
	public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select($this->_operLogVo);
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