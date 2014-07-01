<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hit_ActionLoger
{
	private $m_CI;
	private $m_actionloger;

	function __construct()
	{
		$this->m_CI = & get_instance();
		$this->m_CI->load->model('Hit_ActionLogModel');
		$this->m_actionloger = $this->m_CI->Hit_ActionLogModel;
	}

	/**
	 * 将一条用户行为写入数据库
	 * @param  array $record 用户行为记录
	 * @return bool             是否执行成功
	 */
	public function record($record)
	{
		$this->m_actionloger->insert($record);
		return True;
	}
}