<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 提供与 session 相关的辅助函数
 */


/**
 * 获取session的某个值
 * @param  string $session_name 要获取的 session 的键
 * @return [type] session中的值，不存在则返回false
 */
if( ! function_exists('get_session'))
{
	function get_session($session_name)
	{
		$ci = & get_instance();
		return $ci->session->userdata($session_name);
	}
}