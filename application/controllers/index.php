<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->library('Hit_SaeTOAuth');
		$state = uniqid( 'hitweibo_', true);
		$this->session->set_userdata('weibo_state',$state);
		$authorize_url = $this->hit_saetoauth->get_authorize_url('code', $state);
		$data['authorize_url'] = $authorize_url;

		$this->load->view('index',$data);
	}
}