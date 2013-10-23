<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hit_Controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	
		$this->load->helper('Hit_session');
		
		// 判断用户是否登录
		if( ! get_session('uid') ){
			redirect('/user/login');
		}
	}
}
