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
		if(isset($uploadFile['type'])){
			if( $uploadFile['type'] == 'image/jpeg'){
				return "jpeg";
			}else if($uploadFile['type'] == 'image/png'){
				return "png";
			}else{
				return "gif";
			}
		}
				
		return "";
	}

	/**
	 * 上传文件
	 * @params fileKey 用于标明$_FILES里存放文件的对象的键值
	 * 比如上传头像时，fileKey = "avatarfile"
	 * 上传普通文件时，fileKey = "file"
	 */
	private function _updload_file($fileKey){
		if (!empty($_FILES)) {
			if(!isset($_FILES[$fileKey])){
				return NULL;
			}
			$file = $_FILES[$fileKey];
			if (is_uploaded_file($file['tmp_name']) && $file['error'] == 0) {
				$uploadFile = $file;
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
			}
		}
		return NULL;
	}

	/**
	 * 上传头像
	 */
	public function upload_avatar() {
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		$userInfo = $this->User_model->get("*",array('user_id'=>$user_id));		
		$operFields = get_oper_fields("upload","post",OPERATE_TYPE_MODIFY,$userInfo ? $userInfo['user_name'] : "",'upload/upload_avatar',$_FILES);		
		$filePath = $this->_updload_file("avatarfile");
		if($filePath){
			//将路径存入数据库
			$this->User_model->save(array('avatar'=>$filePath
										,'update_by'=>$userInfo['user_name']
										,'update_time'=>date("YmdHis", time()))
										,array('user_id'=>$user_id));
			printAjaxRaw(array('fileName'=>$filePath
			, 'encode_file_path'=>preg_replace(array('/\//', '/\./'), array('_', '~'), $filePath)
			, 'imgUrl'=>$filePath	//兼容若依接口
			, 'code'=>200),$operFields,$this->Sys_oper_log_model);
		}else{
			printAjaxError('file', '上传失败',$operFields,$this->Sys_oper_log_model);
		}
	}		
}
