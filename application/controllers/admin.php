<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('Hit_AdminModel');
	}

	public function login()
	{
		$this->load->view('admin/login');
	}

	public function confirm()
	{
		$str_userName = $this->input->post('username');
		$str_password = $this->input->post('password');
		if($str_userName && $str_password){
			if($this->Hit_AdminModel->isValid($str_userName, $str_password)){
				$this->session->set_userdata("ADMINLOGIN", $str_userName);
				redirect('admin/main');
			}
		}
		redirect('admin/login');
	}

	public function index()
	{
		if($this->__isLogin()){
			$this->main();
			return;
		}
		$this->login();
	}

	/**
	 * 调用后台管理系统首页
	 * @return void
	 */
	public function main()
	{
		if( ! $this->__isLogin()){
			redirect('admin/login');
		}
		$this->load->view('admin/main');
	}

	public function tab()
	{
		$this->load->view('admin/tab/tab');
	}

	public function middle()
	{
		$this->load->view('admin/middle');
	}

	public function left()
	{
		$this->load->view('admin/left');
	}

	public function top()
	{
		$this->load->view('admin/top');
	}

	public function center()
	{
		$this->load->view('admin/center');
	}

	public function down()
	{
		$this->load->view('admin/down');
	}

	public function logout()
	{
		$this->session->unset_userdata('ADMINLOGIN');
		redirect('admin/login');
	}

	/**
	 * 判断管理员是否登录
	 * @return boolean 登录返回TRUE,否则返回FALSE
	 */
	private function __isLogin()
	{
		$b_isAdminLogin = $this->session->userdata('ADMINLOGIN');
		if($b_isAdminLogin){
			return TRUE;
		}
		return FALSE;
	}
}