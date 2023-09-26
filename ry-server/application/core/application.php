<?php

class Application
{
    /** @var null The controller */
    private $url_controller = null;

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    /** @var array URL parameters */
    private $url_params = array();

    //url上?之后的参数
    private $url_ext_params = NULL;
    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {
            printAjaxError('404', '无效的请求');
        } elseif (file_exists(APP . 'controller/' . $this->url_controller . '.php')) {
            // here we did check for controller: does such a controller exist ?
            //对非白名单的用户进行登录校验
            $user_id = $this->filter($this->url_controller, $this->url_action);
            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require APP . 'controller/' . $this->url_controller . '.php';
            $controllerParams = array('model_name'=>$this->url_controller,'user_id'=>$user_id);
            $this->url_controller = new $this->url_controller($controllerParams);

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {

                if (!empty($this->url_params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$this->url_action}($this->url_ext_params);
                }

            } else {
                if (strlen($this->url_action) == 0) {
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->index();
                }
                else {
                    printAjaxError('404', '无效的请求');
                }
            }
        } else {
            printAjaxError('404', '无效的请求');
        }
    }

    /**
     * 将url?params上params部分转为对象
     */
    private function splitParams($params){
        //在用explode将字符串分割为数组
        $paramsArray = explode('&',$params);
        $fields = array();
        for($i = 0; $i < count($paramsArray); $i++){
            $tmpArray = explode('=',$paramsArray[$i]);
            if(isset($tmpArray[0]) && isset($tmpArray[1])){
                $fields[$tmpArray[0]] = $tmpArray[1];
            }
        }
        $obj = (object)$fields;
        return $obj;
    }

    /**
     * 将ruoyi的url转换成php格式
     */
    private function convertRuoyiUrl($orgUrl){
        //$url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $orgUrl);
            
        //加载url映射表
        if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/ruoyimapper.php'))
        {
            if ( ! file_exists($file_path = APPPATH.'config/ruoyimapper.php'))
            {
                show_error('The configuration file ruoyimapper.php'.' does not exist.');
            }
        }
            
        include($file_path); 

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $requestMethodArray = $ruoyiApiMapper[$requestMethod];
        $orgControl = "";
        $dstControl = "";
        $tmp = $requestMethodArray;
        for($i = 0; $i < count($url); $i++){
            if(!isset($tmp[$url[$i]])){
                break;
            }
            if($orgControl){
                $orgControl .= "/";
            }
            $orgControl .= $url[$i];
            $tmp = $tmp[$url[$i]];
            if(is_string($tmp)){
                $dstControl = $tmp;
                break;
            }
        }
        if(!empty($orgControl) && empty($dstControl)){
            if(isset($tmp['index']) && is_string($tmp['index'])){
                $dstControl = $tmp['index'];
            }
        }
        if(!empty($orgControl) && !empty($dstControl)){
            return str_replace($orgControl,$dstControl,$orgUrl);
        }
        return $orgUrl;
    }
    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_SERVER["REQUEST_URI"])) {
            $requestURI = $_SERVER["REQUEST_URI"];
            $uriArray = explode('?', $requestURI);
            // split URL
            $url = trim($uriArray[0], '/');
            //转换ruoyi的url
            $url = $this->convertRuoyiUrl($url);
            //$url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Put URL parts into according properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;

            // Remove controller and action from the split URL
            unset($url[0], $url[1]);
            
            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);

            if(isset($uriArray[1])){
                $this->url_ext_params = $this->splitParams($uriArray[1]);
            }
        }
    }

    /**
     * 是否在白名单中
     * @return false 未在白名单中，true 在白名单中
     */
    private function isInWhiteList($url_controller,$url_action){
        //加载白名单
		if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/whitelist.php'))
		{
			if ( ! file_exists($file_path = APPPATH.'config/whitelist.php'))
			{
				show_error('The configuration file whitelist.php'.' does not exist.');
			}
		}
		
		include($file_path);        
        //check controller
        if(!isset($whiteList[$url_controller])){
            return false;
        }
        $whiteController = $whiteList[$url_controller];
        if(!isset($whiteController[$url_action])){
            return false;
        }

        if(!$whiteController[$url_action]){            
            return false;
        }
        return true;
    }
    /**
     * 登录过滤器
     * 对非白名单的用户进行登录校验
     * 在application/config/whitelist.php修改whiteList配置
     */
    private function filter($url_controller,$url_action){
        //如果在白名单中，则无须进行登录校验
        if($this->isInWhiteList($url_controller,$url_action)){
            return NULL;
        }
        //否则需要进行登录校验
        $user_id = getUserId();
        if(!$user_id){
            printAjaxError('', '未被授权的请求',NULL,NULL,401);
        }
        return $user_id;
    }
}
