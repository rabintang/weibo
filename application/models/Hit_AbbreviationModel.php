<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 词条的数据处理类
 * 
 * @author Tbin <tbinhit@foxmail.com>
 */
class Hit_AbbreviationModel extends Hit_Model
{
	function __construct()
	{
		parent::__construct('abbreviation');
	}

	/**
	 * 查询与用户相关的词条
	 * @param  array  $params 查询字符串的参数
	 *                        fields array/string 需要查询的字段
	 *                        fui string 用户关注好友列表ID
	 *                        conditions array/string 除与用户相关性外的约束条件
	 *                        orderby array/string 排序条件
	 *                        limit array/integer limit子句
	 * @return string         查询结果,失败返回false
	 */
	public function select_user_relate($params = array(), $escape=TRUE)
	{
		if(isset($params['fui']) && $this->_stringCondition($params['fui'])){
			if(isset($params['conditions']) && $this->_stringCondition($params['conditions'])){
				$params['conditions'] = $this->get_relate_sub_select($params['fui']) . ' AND ' . $params['conditions'];
			} else {
				$params['conditions'] = $this->get_relate_sub_select($params['fui']);
			}
			unset($params['fui']);
		} else {
			return FALSE;
		}
		return $this->select($params, $escape);
	}

	/**
	 * 获取与用户相关的词条数
	 * @param  array $params 查询条件
	 *                       fui string 用户关注列表ID
	 *                       conditions string/array 其余查询条件
	 * @return integer             词条数,失败返回false
	 */
	public function get_relate_rows_num($params = array(), $escape=TRUE)
	{
		if(isset($params['fui']) && $this->_stringCondition($params['fui'])){
			if(isset($params['conditions']) && $this->_stringCondition($params['conditions'])){
				$params['conditions'] = $this->get_relate_sub_select($params['fui']) . ' AND ' . $params['conditions'];
			} else {
				$params['conditions'] = $this->get_relate_sub_select($params['fui']);
			}
			unset($params['fui']);
		} else {
			return FALSE;
		}
		return $this->getRowsNum($params, $escape);
	}

	/**
	 * 获取与用户相关词条的子查询语句
	 * @param  string $fui 用户关注列表ID
	 * @return string      子查询
	 */
	protected function get_relate_sub_select($fui)
	{
		if($this->_stringCondition($fui)){
			$subselect = "abrid IN (SELECT abrid FROM `abbre_weibomsg` WHERE mid 
				IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui})))";
			return $subselect;
		}
		return FALSE;
	}
}