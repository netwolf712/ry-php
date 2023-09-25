<?php

/**
 * Class Problem
 * Formerly named "Error", but as PHP 7 does not allow Error as class name anymore (as there's a Error class in the
 * PHP core itself) it's now called "Problem"
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Upload extends Controller
{
	private $User_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }
    function _createDir($filePath) {
	    if (! file_exists ( $filePath )) {
			if (! mkdir($filePath, 0777))
			    return false;
		}
		
		return $filePath;
	}	
    private function _createDateTimeDir($savePath) {
		$filePath = $savePath. '/' . date ('Y', time());
		if ($this->_createDir($filePath)) {
		    $filePath = $filePath . '/' . date ('m', time());
		    if ($this->_createDir($filePath)){
				$filePath = $filePath . '/' . date ('d', time());
				if ($this->_createDir($filePath)){
					return $filePath;
				}
			}
		    	
		}
		
	    return false;
	}
	private function _getFileExt($uploadFile) {
		if(isset($uploadFile['name'])){
			$fileInfo = pathinfo($uploadFile['name']);
			if(isset($fileInfo['extension'])){
				return $fileInfo['extension'];
			}
		}
		if(isset($uploadFile['type']) && $uploadFile['type'] == 'image/jpeg'){
			return "jpeg";
		}
				
		return "";
	}

	private function _updload_file(){
		if (!empty($_FILES)) {
			if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['error'] == 0) {
				$uploadFile = $_FILES['file'];
				$fileExt = $this->_getFileExt($uploadFile);
				$tmpFileName = date('/Y/m/d/', time()).date('YmdHis', time()) . rand(100000, 999999).'.'.$fileExt;
				$uploadFilePath = UPLOAD_PATH.$tmpFileName;
				//先创建目录
				$this->_createDateTimeDir(UPLOAD_PATH);
				if(@move_uploaded_file($uploadFile['tmp_name'], $uploadFilePath)) {	
					return $uploadFilePath;
				}
				return NULL;
			}else{
				print_r($_FILES);
			}
		}
		return NULL;
	}
	public function upload_avatar() {
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("upload","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'upload/upload_avatar',$_FILES);		
		$filePath = $this->_updload_file();
		if($filePath){
			printAjaxRaw(array('fileName'=>$filePath
			, 'encode_file_path'=>preg_replace(array('/\//', '/\./'), array('_', '~'), $filePath)
			, 'code'=>200),$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError('file', '上传失败',$operFields,$this->Sys_oper_log_model);
		}
	}		
}
