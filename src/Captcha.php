<?php
namespace Kabir\Captcha;

/**
 * PHP Captcha package
 *
 * @copyright Copyright (c) 2017 Kabircse
 * @version 1.x
 * @author Kabir Hossain
 * @contact kabir.cse10@gmail.com
 * @web http://www.programmingdesk.blogspot.com
 * @date 2017-12-31
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

 /**
  * Class Captcha
  * @package Kabir\Captcha
  */
class Captcha{
	public function __construct(){
		// Staring Session
		session_start();
	}
	/**
	 * Create image
	 */
	public static function create_src(){
			$math = self::create_equation();
	    $image = imagecreatetruecolor(190, 100);
	    imagesavealpha($image, true);
			 // transparent background
	    $trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
	    imagefill($image, 0, 0, $trans_colour);
	    // font files
	    $fonts = '1942.ttf';
	    $font_dir = 'captcha/';
	    $font = $font_dir . $fonts;
			// Font Color
	    $font_colour = imagecolorallocate($image, 0, 0, 0);
	    $font_size = 35;
			// get x coordinates for text to be center aligned
	    $x_px = 5;
			// get y coordinates for text to be middle aligned
	    $y_px = $font_size + 12;

			// add text to image
	    imagettftext($image, $font_size, 0, $x_px, $y_px, $font_colour, $font, $math);
			ob_start ();
			imagepng($image);
			// Read image path
			$image_data = ob_get_contents ();
			ob_end_clean ();
			imagedestroy($image);
			//convert image path to base64 encoding
			return base64_encode($image_data);
	}

	/**
	 * create math equation with random number
	 */
	private static function create_equation(){
			$num1 = rand(1, 9);
			$num2 = rand(1, 9);
			$rand_operator_position = rand(0,2);
			$operator = ['+','-','*'] ;
			$rand_operator = $operator[$rand_operator_position];
			$result = self::create_operation($num1,$num2,$rand_operator);
			$math = $num1 . "$rand_operator" . $num2 . "=";
			// Initializing session variable with above generated sub-string
			$_SESSION["captcha_code"] = $result;
			return $math;
	}
/**
 * create math opration using random nubmers
 *
 * @param $num integer, $num2 integer , $rand_operator math oprator
 * @return result of operation
 */
	private static function create_operation($num1,$num2,$rand_operator){
		switch($rand_operator){
			case "+":
				return $num1 + $num2;
			case "-":
				return $num1 - $num2;
			case "*":
				return $num1 * $num2;
			default : return true;
		}
	}

	/*
	 *Generate base64 encode of iamge
	 */
	public static function base64(){
		ob_start ();
		imagepng($this->image);
		// Read image path
		$image_data = ob_get_contents ();
		ob_end_clean ();
		imagedestroy($this->image);
		//convert image path to base64 encoding
		return base64_encode($image_data);
	}

	/**
	 *  Create Image src
	 *
	 */
	public static function image_src() {
		// Format the image SRC:  data:{mime};base64,{data};
		return 'data:image/png;charset=UTF-8;base64,'.self::create_src();
	}

	/**
	 * Make captcha image tag
	 *
	 * @param string $class
	 * @return image tag
	 */
	public static function image($class=""){
		$src = self::image_src();
		// Echo out a sample image
		return '<img src="'.$src.'" class="'.$class.'" />';
	}

	/**
	 * Verify captcha code
	 *
	 * @param string $captcha_code
	 * @return bool
	 */
	public static function verify($captcha_code=''){
		if($_SESSION["captcha_code"]==$captcha_code)
			return true;
		return false;
	}
}
