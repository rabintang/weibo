<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 微博的数据处理类
 * 
 * @author Tbin <tbinhit@foxmail.com>
 */
class Hit_WeibomsgModel extends Hit_Model {

	function __construct(){
		parent::__construct('weibomsg');
	}

	/**
	 * 查询用户关注好友的微博
	 * @param  array  $params 参数列表
	 * @param  bool $escape 是否给字段或表明加反引号
	 * @return array         微博列表
	 */
	public function selectFolloweeMsgs($params = array(), $escape=TRUE)
	{
		if(isset($params['fui']) && $this->_stringCondition($params['fui'])){
			if(isset($params['conditions']) && $this->_stringCondition($params['conditions'])){
				$params['conditions'] = $this->correlateSubSelect($params['fui']) . ' AND ' . $params['conditions'];
			} else {
				$params['conditions'] = $this->correlateSubSelect($params['fui']);
			}
			unset($params['fui']);
		} else {
			return FALSE;
		}
		return $this->select($params, $escape);
	}
	
	/**
	 * 获取用户关注好友微博的子查询语句
	 * @param  string $fui 用户关注列表ID
	 * @return string      子查询
	 */
	protected function correlateSubSelect($fui)
	{
		if($this->_stringCondition($fui)){
			$subselect = "mid IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui}))";
			return $subselect;
		}
		return FALSE;
	}	
}