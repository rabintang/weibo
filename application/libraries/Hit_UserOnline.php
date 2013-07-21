<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与用户在线数据处理相关的类
 */
class Hit_UserOnline {
	private $_saetclient; // HitSaeTClient实例
	private $_uid;

	/**
	 * 用户信息处理类助手
	 * @param string $access_token 用户登录授权码
	 */
	function __construct($access_token){
		$ci = & get_instance();
		$ci->load->library('Hit_SaeTClient');
		$this->_sae_tclient = $ci->hit_saetclient;

		$uid_get = $this->_saetclient->get_uid();
		$this->_uid = $uid_get['uid'];

		$ci->load->config('hit_sina_api_constants');
	}

	/**
	 * 更新或者插入用户个人信息，userlist数据库表中字段
	 * 如果数据库中存在数据则更新，否则执行插入
	 * @return bool 是否更新成功
	 */
	public function update_or_insert_user(){
		$ci = & get_instance();
		$ci->load->helper('date');

		$user = $this->get_user_info();
		$ary_query_data = array(
							'sn' => $user['screen_name'],
							'sx' => $user['gender'],
							'vi' => $user['verified_reason'],
							'de' => $user['description'],
							'ad' => $user['address'],
							'bl' => $user['url'],
							'un' => $user['name'],
							'an' => $user['friends_count'],
							'fn' => $user['followers_count'],
							'mn' => $user['statuses_count'],
							'iu' => $user['profile_image_url'],
							'iv' => $user['iv'],
							'at' => $user['created_at'],
							'ti' => standard_date('DATE_ATOM'),
							'fui' => $this->get_user_friends_ids()
							);

		$ci->load->model('Hit_UserModel');
		if($ci->hit_usermodel->exist_user()){ // This user exists. Then update user's information.
			return $ci->hit_usermodel->update($ary_query_data, array('uid', $this->_uid));
		} else { // Insert user's information.
			$ary_query_data['uid'] = $this->_uid;
			return $ci->hit_usermodel->insert($ary_query_data);
		}
	}

	/**
	 * 获取用户信息
	 * @return array 包含用户信息的关联数组
	 */
	public function get_user_info(){
		$user = $this->_saetclient->show_user_by_id($this->_uid);
		$user['address'] = (string)$user['province'] . ' ' . (string)$user['city'];
		$user['verified'] = $user['verified'] ? 1 : 0;
		return $user;
	}

	/**
	 * 获取用户关注好友ID列表
	 * @param  boolean $return_as_string 是否以字符串形式返回数据（每个ID均用单引号包含，以逗号分隔。用于数据库）
	 * @return array/string 以数组或者字符词返回关注列表
	 */
	public function get_friends_ids($return_as_string = true){
		$ary_friends_ids = array();
		$next_cursor = 0;
		do{
			$response_data = $this->_saetclient->friends_ids_by_id($this->_uid, $next_cursor, MAX_FRIENDSHIP_FRIENDS_IDS_COUNT);
			if($response_data['total_number'] > 0) { // 返回数据不为空
				$ary_friends_ids = array_merge($ary_friends_ids,$response_data['ids']);
			} else {
				break;
			}
			$next_cursor = $response_data['next_cursor'];
		} while($response_data['total_number'] == MAX_FRIENDSHIP_FRIENDS_IDS_COUNT);

		if($return_as_string) { // 按照字符串格式返回
			$str_frdids_ids = "'" . implode("','" $ary_friends_ids) . "'";
			return $str_frdids_ids;
		} else {
			return $ary_friends_ids;
		}
	}

	/**
	 * 获取用户及好友发布的最新若干条微博
	 * @param  integer $max_count 最多返回的微博数
	 * @return array 微博数组
	 */
	public function get_friends_timeline($max_count = 100){
		$ary_statuses = array();

		for($i = 1; $i <= $max_count / MAX_STATUSES_FRIENDS_TIMELINE_COUNT; $i++) {
			$response_data = $this->_saetclient->home_timeline($i);
			$ary_statuses = array_merge($ary_timeline, $response_data['statuses']);
			if($response_data['total_number'] <= $i * MAX_STATUSES_FRIENDS_TIMELINE_COUNT)
			    break;
		}

		return $ary_statuses;
	}

	/**
	 * 获取用户ID
	 * @return string 用户ID
	 */
	public function get_uid(){
		return $this->_uid;
	}
}