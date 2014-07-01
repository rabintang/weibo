<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取词条的相关外部资源
 * 
 * @author Tbin <tbinhit@foxmail.com>
 */
class Hit_ResourceModel extends Hit_Model
{
	function __construct()
	{
		parent::__construct('resource');
	}

	/**
	 * 获取与词条相关的外部资源
	 * @param  array  $params 配置信息
	 * @return array         获取的外部资源
	 */
	public function selectCorrelateresource($params = array())
	{
		if(isset($params['entryid'])){
			if(isset($params['conditions']) && $this->_stringCondition($params['conditions'])){
				$params['conditions'] = "resourceid IN (SELECT resourceid FROM `correlateresource` 
					WHERE entryid={$params['entryid']}" 
					. ' AND ' . $params['conditions'];
			} else {
				$params['conditions'] = "resourceid IN (SELECT resourceid FROM `correlateresource` 
					WHERE entryid={$params['entryid']})";
			}
			unset($params['entryid']);
		} else {
			return FALSE;
		}
		$data = $this->select($params);
		return $data;
	}
}