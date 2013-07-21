<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 回调地址业务处理类
 */
class Callback extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('cookie');
	}

	public function index()	
	{
		$authorize_success = false;
		if($this->input->get_post('code')){
			$this->load->library('Hit_SaeTOAuth');
			$keys = array();

			// 验证state，防止伪造请求跨站攻击
			/*$state = $this->input->get_post('state');
			if ($state || $state != $this->session->userdata('weibo_state')) {
				exit;
			}
			$this->session->set_userdata('weibo_state',''));*/

			$keys['code'] = $this->input->get_post['code'];
			$keys['redirect_uri'] = $this->hit_saetoauth->get_callback_url();
			try {
				$token = $this->hit_saetoauth->get_access_token('code', $keys) ;
				if ($token) {
		        	$this->session->set_userdata('token',$token);
		        	set_cookie('weibojs_'.$this->hit_saetoauth->client_id, http_build_query($token));
		        	$authorize_success = true;
		        }
			} catch (Exception $e) {
			    log_message('error','In callback:' . $e->getMessage());
			}
		}
		
		if($authorize_success) { // 验证成功，更新用户信息，初始化推荐词条
			$this->load->library('Hit_UserOnline',array('access_token'=>$token['access_token']));
			$uid = $this->hit_useronline->get_uid();
			$this->hit_useronline->update_or_insert_user();

			$this->load->library('Hit_KlgRecommender', array('access_token'=>$token['access_token'],
															 'uid'=>$uid));
			$this->hit_klgrecommender->recommden_when_login();
		}

		$data['authorize_success'] = $authorize_success;
		$this->load->view('callback',$data);
	}
}