<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与数据库中用户数据处理相关的类
 */
class Hit_UserModel extends Hit_Model
{
	private $_uid;

	function __construct($params = NULL)
	{
		parent::__construct('userlist');
		$this->_uid = isset($params['uid']) ? (string)$params['uid'] : NULL;
	}

	/**
	 * 判断数据库中是否已存在某用户
	 * @param string $uid 被查询的用户ID，不指定则查询当前用户
	 * @return bool 存在返回true，否则返回false
	 */
	public function exist_user($uid = NULL)
	{
		if($uid == NULL && $this->_uid != NULL) {
			$uid = $this->_uid;
		}
		if($uid != NULL) {
			$sql_select = "SELECT COUNT(*) AS count FROM {$this->table_name} WHERE uid=?";
			$query = $this->db->query($sql_select,array($uid));
			if($query->num_rows() > 0) {
				$row = $query->row();
				if($row->count > 0) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	/**
	 * 获取 userlist 数据表中的 fui 字段值,即用户关注好友列表
	 * @param  string $uid 用户ID,没有则获取当前用户
	 * @return string      fui字段值,失败返回false
	 */
	public function get_fui($uid = NULL)
	{
		if( ! $this->string_condition($uid)){
			if($this->string_condition($this->_uid)) {
				$uid = $this->_uid;
			} else {
				return FALSE;
			}
		}
		$query = $this->select(array('fields'=>'fui', 'conditions'=>array('uid'=>$uid)));
		if($query){
			return $query[0]['fui'];
		} else {
			return FALSE;
		}
	}

	/**
	 * 更新用户信息
	 * @param  array $user 包含用户信息的关联数组
	 * @return bool 更新成功返回True，否则返回False
	 */
	/*public function update($user, $condition = NULL){
		if($user) {
			if(!$this->string_condition($condition)){

			}
			if(!isset($user['uid'])) {
				$user['uid'] = $this->_uid;
			}
			try{
				if($this->exists_user($user['uid'])){ // This user exists. Then update user's information.
					$where = "uid='{$user['uid']}'";
					unset($user['uid']);
					parent::update($user, $condition);
				}
			} catch(Exception $e) {
				log_message('error', 'On update ' . $user['sn'] . ':' . $e->getMessage());
				return False;
			}
		}
		return False;
	}*/

	/**
	 * 插入用户信息
	 * @param  array $user 待插入的用户数据
	 * @return bool 插入成功返回True，否则返回False
	 */
	/*public function insert($user){
		if($user) {
			try{
				$sql_insert = $this->db->insert_string('userlist', $user);
				$this->db->query($sql_insert);
				return $this->db->affected_rows() > 0 ? True : False;
			} catch(Exception $e) {
				log_message('error', 'On insert ' . $user['sn'] . ':' . $e->getMessage());
				return False;
			}
		}
		return False;
	}*/
}
