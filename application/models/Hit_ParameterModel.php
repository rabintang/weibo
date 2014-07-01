<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系统参数数据层
 */
class Hit_ParameterModel extends Hit_Model
{
	function __construct()
	{
		parent::__construct('parameter');
	}
}