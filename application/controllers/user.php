<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('Hit_weibo_api');
	}

	public function login()
	{
		$authorize_url = get_authorize_url();
		$data = array(
			'message' => '请先登录后再继续操作',
			'head' => '登录',
			'authorize_url' => $authorize_url 
		);
		$this->load->view('login', $data);
	}

	public function login_out()
	{
		$this->session->sess_destroy();
		$authorize_url = get_authorize_url();
		$data = array(
			'head' => '登出',
			'message' => '您已经成功退出知识推荐助手',
			'authorize_url' => $authorize_url
		);
		$this->load->view('login', $data);
	}

	/**
	 * 用户登录失败时
	 */
	public function fail()
	{
		$authorize_url = get_authorize_url();
		$data = array(
			'head' => '登录失败',
			'message' => '登录失败,请重新登录',
			'authorize_url' => $authorize_url
		);
		$this->load->view('login', $data);
	}
}
