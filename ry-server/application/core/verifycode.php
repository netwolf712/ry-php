<?php
/**
 * Security secoder
 * 
 * Security Code requires authentication code text twist, rotate, 
 * using different fonts, add the interference code.
 *
 */
class VerifyCode {
    /**
	 * session subscript of the verifycode
	 */
	public static $seKey = 'www.hzppc.com';
	public static $expire = 3000;     //Verify code expires time(s)
	/**
	 * The characters used in verification code, 01IO confusing, do not recommend a
	 */
	public static $codeSet = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	public static $fontSize = 16;     // Verify code font size(px)
	public static $useCurve = true;   // Whether painting confusion curve
	public static $useNoise = true;   // Whether add noise	
	public static $imageH = 38;        // Verify code image width
	public static $imageL = 116;        // Verify code image length
	public static $length = 4;        // Length of the verify code
	public static $bg = array(243, 251, 254);  // background	
	protected static $_image = null;     // Example image of the verify code
	protected static $_color = null;     // Font color of the verify code
	public function __construct($useNoise = true, $useCurve = true, $font = 25) {
	    self::$useNoise = $useNoise;
	    self::$useCurve = $useCurve;
	    self::$fontSize = $font;  
	}
	
	/**
	 * Output verify code and the verify code in the value of the saved session
	 */
	public static function entry() {
		//Image width(px)
		self::$imageL || self::$imageL = self::$length * self::$fontSize * 1.5 + self::$fontSize*1.5;
		//Image height(px)
		self::$imageH || self::$imageH = self::$fontSize * 2;
		// Create self::$imageL x self::$imageH image
		self::$_image = imagecreate(self::$imageL, self::$imageH);
		//Set the background
		imagecolorallocate(self::$_image, self::$bg[0], self::$bg[1], self::$bg[2]); 
		//Random font color of the verify code
		self::$_color = imagecolorallocate(self::$_image, mt_rand(1, 120), mt_rand(1, 120), mt_rand(1, 120));
		//Random font of the verify code
		//$ttf = './ttfs/' . mt_rand(1, 3) . '.ttf';
		$ttf = APPPATH.'/ttfs/3.ttf';
		
		
		//Drawn verify code
		$code = array(); //Verify code
		$codeNX = 0; //The left margin of verify code from the n characters
		for ($i = 0; $i<self::$length; $i++) {
			//$code[$i] = self::$codeSet[mt_rand(0, 27)];
			$code[$i] = self::$codeSet[mt_rand(0, 30)];
			//$codeNX += mt_rand(self::$fontSize*1.2, self::$fontSize*1.6);			
			$codeNX += self::$fontSize*1.3;
			//Write a verify code character
			//imagettftext(self::$_image, self::$fontSize, mt_rand(-40, 70), $codeNX, self::$fontSize*1.5, self::$_color, $ttf, $code[$i]);
			imagettftext(self::$_image, self::$fontSize, 0, $codeNX, self::$fontSize*1.5, self::$_color, $ttf, $code[$i]);
		}
		
	    $redis = new CI_Redis();
		$strCode = join('', $code);
		$k = self::$seKey.strtolower($strCode);
		$redis->set($k,$strCode);		
		$redis->EXPIRE($k, self::$expire);
		ob_start();// 打开输出控制缓冲
		imagepng(self::$_image);
		$image_data = ob_get_contents();// 返回输出缓冲区的内容
		$base64Image = base64_encode($image_data);
		imagedestroy(self::$_image);
		ob_end_clean();// 清空（擦除）缓冲区并关闭输出缓冲
		return $base64Image;
	}    
	
	/** 
	 * Draw a two together constitute the sine curve for the random interference line (you can change more handsome curve function) 
     *
	 *		Sinusoidal analytic function：y=Asin(ωx+φ)+b
	 *      Parameter Description：
	 *        A：Decided to peak (ie, longitudinal tensile compression ratio)
	 *        b：That the position of the waveform between the Y axis or vertical distance (on the plus next less)
	 *        φ：X-axis position of the waveform and determine relationships or lateral distance (left plus right-minus)
	 *        ω：Decision cycle (the least positive period T = 2π / | ω |)
	 *
	 */
    protected static function _writeCurve() {
		$A = mt_rand(1, self::$imageH/2);                  //Amplitude
		$b = mt_rand(-self::$imageH/4, self::$imageH/4);   //Y-axis offset
		$f = mt_rand(-self::$imageH/4, self::$imageH/4);   //X-axis offset
		$T = mt_rand(self::$imageH*1.5, self::$imageL*2);  //Cycle
		$w = (2* M_PI)/$T;
						
		$px1 = 0;  //Abscissa of the starting position curve
		$px2 = mt_rand(self::$imageL/2, self::$imageL * 0.667);  //End position curve abscissa	    	
		for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
			if ($w!=0) {
				$py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;  // y = Asin(ωx+φ) + b
				$i = (int) ((self::$fontSize - 6)/4);
				while ($i > 0) {	
				    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color);  //This painting pixel performance is better than a lot of imagettftext and imagestring			    
				    $i--;
				}
			}
		}
		
		$A = mt_rand(1, self::$imageH/2);                  //Amplitude
		$f = mt_rand(-self::$imageH/4, self::$imageH/4);   //X-axis offset
		$T = mt_rand(self::$imageH*1.5, self::$imageL*2);  //Cycle
		$w = (2* M_PI)/$T;		
		$b = $py - $A * sin($w*$px + $f) - self::$imageH/2;
		$px1 = $px2;
		$px2 = self::$imageL;
		for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
			if ($w!=0) {
				$py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;  // y = Asin(ωx+φ) + b
				$i = (int) ((self::$fontSize - 8)/4);
				while ($i > 0) {			
				    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color);  //Here (while) loop drawing pixels and imagestring than imagettftext a draw with the font size (not the while loop) performance is much better
				    $i--;
				}
			}
		}
	}
	
	/**
	 * Draw noise
	 * Pictures of different colors to write the letters or numbers
	 */
	protected static function _writeNoise() {
		for($i = 0; $i < 10; $i++){
			//Noise color
		    $noiseColor = imagecolorallocate(
		                      self::$_image, 
		                      mt_rand(150,225), 
		                      mt_rand(150,225), 
		                      mt_rand(150,225)
		                  );
			for($j = 0; $j < 5; $j++) {
				//Draw noise
			    imagestring(
			        self::$_image,
			        5, 
			        mt_rand(-10, self::$imageL), 
			        mt_rand(-10, self::$imageH), 
			        self::$codeSet[mt_rand(0, 27)], //The text for the random noise letters or numbers
			        $noiseColor
			    );
			}
		}
	}
	
	/**
	 * Verify verification code is correct
	 *
	 * @param string $code User authentication code
	 * @param bool User authentication code is correct
	 */
	public static function check($code) {
		if(empty($code)){
			return false;
		}
		$redis = new CI_Redis();	
		$redisCode = $redis->get(self::$seKey.strtolower($code));
		if(!empty($redisCode)){
			return true;
		}

		return false;
	}	
}
// END Securitysecoderclass class

/* End of file Securitysecoderclass.php */
