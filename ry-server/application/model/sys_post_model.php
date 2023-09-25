<?php
class Sys_post_model extends Model {


	private $_postVo = "post_id as postId,post_code as postCode,post_name as postName,post_sort as postSort"
						.",status,create_by as createBy,create_time as createTime,update_by as updateBy,update_time as updateTime,remark";


    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"role_sort","asc");
	}
	public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($this->_postVo,$strWhere,$limit,$offset,"post_sort","asc");
	}

	public function selectPostByUserId($userId){
		$ret = array();
		$queryStr = "select p.post_id,p.post_name
        from sys_post p
	        left join sys_user_post up on up.post_id = p.post_id
	        left join sys_user u on u.user_id = up.user_id
	    where u.user_id = {$userId}";
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

    public function get2($strWhere = NULL) {
		$ret = array();
		$this->db->select($this->_postVo);
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