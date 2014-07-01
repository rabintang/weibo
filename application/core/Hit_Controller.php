<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hit_Controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	
		$this->load->helper('Hit_session');
		$this->load->helper('date');
		$this->load->helper('url');
		$this->load->library('Hit_ActionLoger');
		
		// 判断用户是否登录
		if( ! get_session('uid') ){
			redirect('/user/login');
		}

		// 记录用户行为
		$arr_post_data = $this->input->post();
		$str_post_data = '';
		if($arr_post_data and sizeof($arr_post_data) > 0) {
			foreach($arr_post_data as $key=>$value){
				$value = str_replace('#', '##', $value);
				$str_post_data .= $key . ':' . $value . '#';
			}
		}
		$str_post_data = rtrim($str_post_data, '#');
		$str_ip_address = $this->input->ip_address();
		$str_user_agent = $this->input->user_agent();
		$str_action_time = standard_date('DATE_ATOM');
		$str_current_url = current_url();
		$str_uid = get_session('uid');
		$record = array(
			'uid' => $str_uid,
			'ip' => $str_ip_address,
			'useragent' => $str_user_agent,
			'actiontime' => $str_action_time,
			'url' => $str_current_url,
			'postdata' => $str_post_data
			);
		$this->hit_actionloger->record($record);
	}
}
