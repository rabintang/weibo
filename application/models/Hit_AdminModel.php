<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理员数据层
 */
class Hit_AdminModel extends Hit_Model
{
	function __construct()
	{
		parent::__construct('admin');
	}

	/**
	 * 判断账户名和密码是否合法
	 * @param  string  $str_userName 用户名
	 * @param  string  $str_password 密码
	 * @return boolean               合法返回TRUE,否则返回FALSE
	 */
	public function isValid($str_userName, $str_password)
	{
		$str_condition = "username='" . $str_userName . "' AND password='" . $str_password . "'";
		$arr_results = $this->select(array(
			'fields' => 'adminid',
			'conditions' => $str_condition
		), FALSE);
		if($arr_results && sizeof($arr_results) > 0){
			return TRUE;
		}
		return FALSE;
	}
}