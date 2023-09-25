<?php
class Sys_user_model extends Model {

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL, $by = 'create_time') {
		return $this->_gets($select,$strWhere,$limit,$offset,$by,"desc");
	}

    public function validateUnique($username) {
		$adminInfo = $this->get('*', array("lower(user_name)"=>strtolower($username)));
		if ($adminInfo) {
		    return true;
		}

		return false;
	}

	public function login($username, $password) {
	    $userInfo = $this->get('*', array("lower(user_name)"=>strtolower($username)));
	    if ($userInfo) {
	        if ($userInfo['password'] == $this->getPasswordSalt($username, $password)) {
	            return $userInfo;
	        }
	    }

	    return false;
	}
	
	public function getPasswordSalt($username, $password) {
		$addTime = 0;
	    $this->db->select("{$this->_tableName}.create_time");
		$query = $this->db->get_where($this->_tableName, array('lower(user_name)'=>strtolower($username)));
	    if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $addTime = $ret[0]['create_time'];
        }
         
        return md5(strtolower($username).$addTime.$password);
	}
	
	
	public function gets_ids($ids = '') {
		$ret = array();
		$ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $ids);

		if(!$ids) return NULL;
		$query = $this->db->query("select id as user_id,mobile,email,real_name as name from user where id in ({$ids}) order by field(id, {$ids})");
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}
		return $ret;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */