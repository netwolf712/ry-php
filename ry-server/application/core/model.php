<?php

class Model
{
    function __construct($db,$modelName)
    {
        try {
            $this->db = $db;
            $this->_tableName = $modelName;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    public function rowCount($where = NULL)
    {
		$count = 0;
		$this->db->select("count(*) as 'count'");
		$query = $this->db->get_where($this->_tableName, $where);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}
		return $count;        
    }

    public function get($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}   
    
	public function save($data, $where = NULL) {
		$ret = 0;

		if (! empty($where)) {
			$ret = $this->db->update($this->_tableName, $data, $where);
		} else {
			$this->db->insert($this->_tableName, $data);
			$ret = $this->db->insert_id();
		}

		return $ret > 0 ? $ret : FALSE;

	}

	public function delete($where = '') {
		return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
	}    
	
	protected function _gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL,$orderBy = NULL,$orderType = "ASC") {
		$ret = array();
		$this->db->select($select);		
		if($orderBy && $orderType){
			$this->db->order_by("{$this->_tableName}.{$orderBy}", $orderType);
		}
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
	    if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
	}


	public function _gets2($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL,$orderBy = NULL,$orderType = "asc")
	{
		$ret = array();
		$queryStr = "select {$select} from {$this->_tableName}";
		if($strWhere){
			$queryStr .= " where {$strWhere} ";
		}
		if($orderBy && $orderType){
			$queryStr .= " order by {$this->_tableName}.{$orderBy} {$orderType}";
		}
		if($limit){
			$queryStr .= " limit {$limit}";
		}
		if($offset){
			$queryStr .= " offset {$offset}";
		}
		$query = $this->db->query($queryStr);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function rowCount2($strWhere = NULL) {
		$count = 0;
		$query = $this->db->query("select count(*) as 'count' from {$this->_tableName} where {$strWhere}");
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}
}
