<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 跟新浪微博API处理相关的功能函数
 */

/**
 * 将微博内容同转发内容拼接起来，构成一条完整数据并返回
 * @param  array $status 原状态数组
 * @return string 成功则返回完整数据，否则返回空字符串
 */
if( ! function_exists('get_integrated_status'))
{
	function get_integrated_status($status)
	{
		$status_text = '';
		if(isset($status['text'])) {
			$status_text = $status['text'];
			while(isset($status['retweeted_status'])){ // To handle the retweeted status.
				$status = $status['retweeted_status'];
				if(isset($status['user'])){ // If the status is not deleted by the owner.
					$status_text .= '//@' . $status['user']['screen_name'] . $status['text'];
				}
			}
		}
		return $status_text;
	}
}

if( ! function_exists('get_authorize_url') )
{
	function get_authorize_url()
	{
		$CI = & get_instance();
		$CI->load->library('Hit_SaeTOAuth');
		$state = uniqid( 'hitweibo_', true);
		$CI->session->set_userdata('weibo_state',$state);
		$authorize_url = $CI->hit_saetoauth->get_authorize_url('code', $state);
		return $authorize_url;
	}
}
