<?php
/*
 * Created on 2016-04-28
 *
 * @author xingang
 * @require (PHP 4 >= 4.0.2, PHP 5, PHP 7)
 * @require  key length must more than 16 !!!
 * @required_php_extention mcrypt
 */
class AesEncrypt{
	
	private $key = null;

	public function __construct($key) {
		$this->key = $key;
	}
	/**
	 * 加密函数
	 * @param string data
	 * @return string 加密后的字符串
	 */
	public function encrypt($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'',MCRYPT_MODE_CBC,'');
		$iv = substr($this->key,0,16);
		mcrypt_generic_init($td,$this->key,$iv);
		$length=32;
		$count = mb_strlen($data);
		$amont = $length-($count%$length);
		if($amont == 0)
			$amont = $length;
		$pad_char = chr($amont&0xFF);
		$data = $data.str_repeat($pad_char,$amont);
		$encrypted = mcrypt_generic($td,$data);
		mcrypt_generic_deinit($td);

		return $encrypted;
	}
	/**
	 * 解密函数
	 * @param string data 加密过的字符串
	 * @return string 解密后的字符串
	 */
	public function decrypt($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'',MCRYPT_MODE_CBC,'');
		$iv = substr($this->key,0,16);
		mcrypt_generic_init($td,$this->key,$iv);
		$data = mdecrypt_generic($td,$data);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
                
		return rtrim($data,substr($data,-1));
	}
}

?>
