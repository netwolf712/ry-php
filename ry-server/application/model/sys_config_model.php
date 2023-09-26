<?php
class Sys_config_model extends Model {


	private $_configVo = "config_id as configId,config_name as configName,config_key as configKey,config_value as configValue"
						.",config_type as configType,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark";


    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"config_id","asc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($this->_configVo,$strWhere,$limit,$offset,"config_id","asc");
	}

    public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select($this->_configVo);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */