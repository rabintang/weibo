<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hit_UserLoger
{
	private $m_CI;
	private $m_userloger;

	function __construct()
	{
		$this->m_CI = & get_instance();
		$this->m_CI->load->model('Hit_UserLogModel');
		$this->m_userloger = $this->m_CI->Hit_UserLogModel;
	}

	/**
	 * 将一条用户行为写入数据库
	 * @param  array $record 用户行为记录
	 * @return bool             是否执行成功
	 */
	public function record($record)
	{
		$this->m_userloger->insert($record);
		return True;
	}
}