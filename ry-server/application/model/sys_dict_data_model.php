<?php
class Sys_dict_data_model extends Model {

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"dict_sort","asc");
	}

	public function gets2($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($select,$strWhere,$limit,$offset,"dict_sort","asc");
	}


	public function getMaxDictValue($strWhere = NULL) {
		$count = 0;
		$this->db->select("max(dict_value + 0) as 'count'");
		$query = $this->db->get_where($this->_tableName, $strWhere);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */