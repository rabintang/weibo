<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->helper('Hit_weibo_api');
		
		$data['authorize_url'] = get_authorize_url();

		$this->load->view('index',$data);
	}
}
