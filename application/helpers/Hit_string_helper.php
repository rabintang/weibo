<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 与字符串处理相关的函数
 */

/**
* 计算UTF8中英文混合字符串的长度
* 中文算两个字符，英文数字算一个字符
* @return $length
*/
if( ! function_exists('UTF8_length'))
{
	function UTF8_length($str) {
	    $length=0;
	    $asclen=strlen($str);
	    $ind=0;
	    for($ind=0;$ind<$asclen;) {
	            if(ord(substr($str,$ind,1))>0x7F) {
	                    $length = $length + 2;
	                    $ind = $ind + 3;
	            } else {
	                    $length++;
	                    $ind++;
	            }
	    }
	    return $length;
	}
}

/**
 * 从UTF8中英文混合字符串中截取字符串
 * 中文算两个字符，英文数字算一个字符，截有半个汉字时取完整汉字
 * @parm $str, $start, $length
 * @return $length
 */
if( ! function_exists('UTF8_substr'))
{
	function UTF8_substr($str, $start, $length) {
	    $alllen=0;
	    $ind=0;
	    $asclen=strlen($str);
	    $isasc = true;
	    $ret_str = "";
	    for($ind=0;$ind<$asclen;){
	        if(ord(substr($str,$ind,1))>0x7F) {
	            $isasc = false;
	            $char = substr($str,$ind,3);
	        }else{
	            $isasc = true;
	            $char = substr($str,$ind,1);
	        }
	        if($alllen >= $start)
	            $ret_str .= $char;
	        if($isasc) {
	            $alllen++;
	            $ind++;
	        }else{
	            $alllen = $alllen + 2;
	            $ind = $ind + 3;
	        }
	        if(($length > 0) & ($alllen >= ($start + $length))) break;
	    }
	    return $ret_str;
	}
}

/**
 * 从UTF8中英文混合字符串中确定给定字符串的位置
 * 中文算两个字符，英文数字算一个字符，返回字符数
 * @return $position
 */
if( ! function_exists('UTF8_stripos'))
{
	function UTF8_stripos($source, $key){
	    $pos = stripos($source,$key);
	    $blen = 0;
	    if($pos){
	        $blen = Tool::UTF8_length(substr($source,0,$pos));
	    }
	    return $blen;
	}
}