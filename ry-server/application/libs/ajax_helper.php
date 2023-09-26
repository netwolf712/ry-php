<?php  
function get_oper_fields($title,$requestMethod,$businessType,$operName,$operUrl,$operParam){
	$operStr = $operParam ? (is_string($operParam) ? $operParam : json_encode($operParam)) : "";
	$fields = array('title'=>$title
					,'request_method'=>$requestMethod
					,'business_type'=>$businessType
					,'oper_name'=>$operName
					,'oper_url'=>$operUrl
					,'oper_ip'=>getIp()
					,'oper_param'=>$operStr
					,'oper_time'=>date('Y-m-d H:i:s',time()));
	return $fields;
}
function _write_log($model,$fields,$status,$jsonResult,$errorMsg = NULL){
	$fields['status'] = $status;
	$fields['json_result'] = $jsonResult;
	$fields['error_msg'] = $errorMsg;
	if(isset($model)){
		$model->save($fields);
	}
}
/**
 * print ajax error
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('printAjaxError')) {
	function printAjaxError($field =  '', $message = '',$fields = NULL,$model = NULL,$code = 1) {
		$messageArr = array(
		              'success'=> false,
		              'field'=>   $field,
                      'message'=> $message,					  
					  'msg'=> $message,	//兼容ruoyi
					  'code'=>$code	//兼容ruoyi，code不能为0，否则会触发前端bug（const code = res.data.code || 200;）
                      );
        $str = json_encode($messageArr);
		if($fields){
			_write_log($model,$fields,FAILURE,$str,$message);
		}
		echo $str;
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('printAjaxSuccess')) {
	function printAjaxSuccess($field =  '', $message = '',$fields = NULL,$model = NULL) {
		$messageArr = array(
		              'success' => true,
		              'field'=>   $field,
                      'message'   => $message,
					  'code'=>200
                      );
		$str = json_encode($messageArr);
		if($fields){
			_write_log($model,$fields,SUCCESS,$str);
		}
		echo $str;
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	array
 * @return	json
 */
if ( ! function_exists('printAjaxData')) {
	function printAjaxData($data,$fields = NULL,$model = NULL) {
		$messageArr = array(
		              'success' => true,
                      'data'   => $data,
					  'code'=>200
                      );
		$str = json_encode($messageArr);
		if($fields){
			_write_log($model,$fields,SUCCESS,$str);
		}
		echo $str;
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	array
 * @return	json
 */
if ( ! function_exists('printAjaxList')) {
	function printAjaxList($data,$total,$fields = NULL,$model = NULL) {
		$messageArr = array(
		              'success' => true,
                      'rows'   => $data,
					  'total' => intval($total),
					  'code'=>200
                      );
        $str = json_encode($messageArr);
		if($fields){
			_write_log($model,$fields,SUCCESS,$str);
		}
		echo $str;
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	array
 * @return	json
 */
if ( ! function_exists('printAjaxRaw')) {
	function printAjaxRaw($data,$fields = NULL,$model = NULL) {
        $str = json_encode($data);
		if($fields){
			_write_log($model,$fields,SUCCESS,$str);
		}
		echo $str;
        exit;
	}
}
/* End of file ajax_helper.php */