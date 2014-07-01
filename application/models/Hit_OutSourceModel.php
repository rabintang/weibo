<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取词条的相关外部资源
 * 
 * @author Tbin <tbinhit@foxmail.com>
 */
class Hit_OutSourceModel extends Hit_Model
{
	function __construct()
	{
		parent::__construct('outsource');
	}

	/**
	 * 获取与词条相关的外部资源
	 * @param  array  $params 配置信息
	 * @return array         获取的外部资源
	 */
	public function select_abbre_relate($params = array())
	{
		if(isset($params['abrid'])){
			if(isset($params['conditions']) && $this->_stringCondition($params['conditions'])){
				$params['conditions'] = "osid IN (SELECT osid FROM `abbre_outs` WHERE abrid={$params['abrid']}" 
					. ' AND ' . $params['conditions'];
			} else {
				$params['conditions'] = "osid IN (SELECT osid FROM `abbre_outs` WHERE abrid={$params['abrid']})";
			}
			unset($params['abrid']);
		} else {
			return FALSE;
		}
		$data = $this->select($params);
		return $data;
	}
}