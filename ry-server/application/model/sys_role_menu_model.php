<?php
class Sys_role_menu_model extends Model {

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		return $this->_gets($select,$strWhere,$limit,$offset,"role_id","asc");
	}
	public function gets2($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL)
	{
		return $this->_gets2($select,$strWhere,$limit,$offset,"role_id","asc");
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */