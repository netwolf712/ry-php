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
class Monitor extends Controller
{
	private $User_model = NULL;
	private $Sys_oper_log_model = NULL;
    public function __construct($params) {
		parent::__construct($params);
        $this->User_model = Helper::load_model("Sys_user",$this->db);
		$this->Sys_oper_log_model = Helper::load_model("Sys_oper_log",$this->db);
    }

	//获取CPU信息
	private function _getCPUInfo(){
		$cpu = array(
			"cpuNum"=>2,
			"free"=>100,
			"sys"=>0,
			"total"=>0,
			"used"=>0,
			"wait"=>0
		);
		//获取cpu核心数
		$fp = popen('sysctl hw.physicalcpu',"r");
		$rs = fread($fp,1024);
		pclose($fp);
		if($rs){
			$tmpArray = explode(':',$rs);
			if(isset($tmpArray[1])){
				$cpu['cpuNum'] = intval(trim($tmpArray[1]));
			}
		}
		//获取cpu使用情况
		$fp = popen('top -l 1 | grep -E "^CPU"',"r");
		$rs = fread($fp,1024);
		pclose($fp);
		if($rs){
			$tmpArray = explode(':',$rs);
			if(isset($tmpArray[1])){
				$tmpArray2 = explode(',',$tmpArray[1]);
				if(isset($tmpArray2[0])){					
					$cpu['used'] = substr($tmpArray2[0],0,strpos($tmpArray2[0],'%'));
				}
				if(isset($tmpArray2[1])){
					$cpu['sys'] = substr($tmpArray2[1],0,strpos($tmpArray2[1],'%'));
				}
				if(isset($tmpArray2[2])){
					$cpu['free'] = substr($tmpArray2[2],0,strpos($tmpArray2[2],'%'));
				}								
			}
		}		
		return $cpu;
	}
	//查找字符串中的数字部分
	private function _findNum($str){
		$str=trim($str);
 		$resut = "";
		 for($i = 0; $i < strlen($str); $i++){
			 if(is_numeric($str[$i])){
				 $resut .= $str[$i];
			 }
		 }
		 return $resut;
	}
	//获取内存信息
	private function _getMEMInfo(){
		$mem = array(
			"free"=>0,
			"total"=>0,
			"usage"=>0,
			"used"=>0
		);
		$totalMem = 0;
		$usedMem = 0;
		$fp = popen('top -l 1 | grep -E "^PhysMem"',"r");
		$rs = fread($fp,1024);
		pclose($fp);
		if($rs){
			$tmpArray = explode(':',$rs);
			if(isset($tmpArray[1])){
				$tmpArray2 = explode(' ',trim($tmpArray[1]));
				if(isset($tmpArray2[0])){
					$totalMem = $this->_findNum($tmpArray2[0]);
				}
				if(isset($tmpArray2[2])){
					$usedMem = $this->_findNum($tmpArray2[2]);
					$usedMem = round(floatval($usedMem) / 1024,2);
				}				
			}
			$mem['total'] = $totalMem;
			$mem['used'] = $usedMem;
			$mem['free'] = $totalMem - $usedMem;
			if($totalMem){
				$mem['usage'] = round(floatval($usedMem) / floatval($totalMem),2);
			}
		}
		return $mem;
	}

	//去除多余的空格，只保留一个
	private function _merge_spaces ( $string )
	{
		return preg_replace("/\s(?=\s)/","\\1",$string);
	}
	//获取文件系统信息
	private function _getFileSysInfo(){
		$sysFiles = array();
		$fp = popen('df -h',"r");
		//读取第一行，为标题，不需要
		$str = fgets($fp);
		while (!feof($fp)){
			$str = fgets($fp);
			$str = $this->_merge_spaces($str);
			if(!$str){
				continue;
			}
			$tmpArray = explode(' ',$str);
			if(isset($tmpArray) && count($tmpArray) > 8){
				if(strpos($tmpArray[0],'dev') == false){
					continue;
				}
				$file = array(
					'typeName'=>$tmpArray[0],
					'total'=>$tmpArray[1],
					'free'=>$tmpArray[3],
					'used'=>$tmpArray[2],
					'dirName'=>$tmpArray[8],
				);
				array_push($sysFiles,$file);
			}
		}
		return $sysFiles;
	}
    
	public function server(){
		$user_id = $this->login_user_id;
		if (!$user_id) {
			printAjaxError('username', '会话已失效，请重新登录');
		}
		// $cpu = array(
		// 	"cpuNum"=>2,
		// 	"free"=>98.15,
		// 	"sys"=>0,
		// 	"total"=>201000,
		// 	"used"=>1,
		// 	"wait"=>0
		// );
		// $mem = array(
		// 	"free"=>3.97,
		// 	"total"=>7.31,
		// 	"usage"=>45.72,
		// 	"used"=>3.34
		// );
		// $sys = array(
		// 	"computerIp"=>"127.0.0.1",
		// 	"computerName"=>"iZwz90rjtrmd83mt2s0df8Z",
		// 	"osArch"=>"amd64",
		// 	"osName"=>"Linux"
		// );
		// $sysFiles = array();
		// $file0 = array(
		// 	"dirName"=>"/",
		// 	"free"=>"25.2 GB",
		// 	"sysTypeName"=>"ext4",
		// 	"total"=>"39.2 GB",
		// 	"typeName"=>"/",
		// 	"usage"=>35.61,
		// 	"used"=>"14.0 GB"
		// );
		// array_push($sysFiles,$file0);

		$serverInfo = array(
			"cpu"=>$this->_getCPUInfo(),
			"mem"=>$this->_getMEMInfo(),
			//"sys"=>$sys,
			"sysFiles"=>$this->_getFileSysInfo()
		);
		printAjaxData($serverInfo);
	}
}
