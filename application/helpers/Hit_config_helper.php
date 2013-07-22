<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与配置信息相关的一组函数
 */

/**
 * 获取指定配置文件的配置信息
 * @param  string/array $keys 要获取的配置信息的键值
 * @param  string $file 配置文件名称
 * @return string/array       配置信息,不存在返回FALSE
 */
if( ! function_exists('get_config_value'))
{	
	function get_config_value($keys, $file = 'hit_config')
	{
		$CI = & get_instance();
		$CI->load->config($file, TRUE);
		if(is_array($keys)){
			$values = array();
			foreach($keys as $key){
				$values[$key] = get_config_value($key, $file);
			}
			return $values;
		}
		return $CI->config->item($keys, $file);
	}
}

if( ! function_exists('load_constant_value'))
{
	function load_constant_value($file = 'hit_sina_api')
	{
		$config_path = APPPATH . 'config/' . $file . '.php';
		include_once($config_path);
	}
}
