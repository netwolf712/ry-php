<?php  

/**
 * 产生user_id的加密数据
 */
function gen_user_code($user_id)
{
	$timestamp = time();
	$payload = array('user_id'=> $user_id
		,'exp'=> $timestamp + SESSION_TIME
		,'timestamp'=> $timestamp);
	$token = Jwt::getToken($payload,JWT_SERCRET,array("alg"=> "HS256", "sign_type"=>"SIGN"));
	return $token;	
}

/**
 * 根据加密数据获取user_id
 */
function get_user_id($en_str)
{
	if(!Jwt::verifyToken($en_str,JWT_SERCRET)){
		return false;
	}
	$redis = new CI_Redis();
	return $redis->get($en_str);
}

/**
 * 定义getallheaders函数
 * 高版本php自带此函数
 */
if ( !function_exists ( 'getallheaders' ) ){
	function getallheaders($param = null) {

		$headers = array();

		foreach ($_SERVER as $name => $value) {

			if (substr($name, 0, 5) == 'HTTP_') {

				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;

			}

		}

		if($param != null){

			return $headers[$param];

		}

		return $headers;

	}
}

/**
 * 从消息头中获取token
 */
function getEnUserId(){
	$headers = getallheaders();
	if(isset($headers["Authorization"])){
		return trim(str_ireplace("Bearer","",$headers["Authorization"]));
	}
	return NULL;
}

function getUserId()
{
	//从Authorization中读取
	$en_user_id = getEnUserId();
	if($en_user_id){
		$user_id = get_user_id($en_user_id);
		if($user_id){
			//重新刷新一下超时时间
			$redis = new CI_Redis();
			$redis->EXPIRE($en_user_id, SESSION_TIME); 
			return $user_id;
		}
	}			
	return NULL;
}

function _is_admin($userId){
	if($userId == 1){
		return true;
	}
	return false;
}
/* End of file user_helper.php */