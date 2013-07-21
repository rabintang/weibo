<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 提供给用户推荐词条的各种方法
 */
class Hit_KlgRecommender
{
	private $_uid;
	private $_saetclient;
	private $_abbreviater;
	private $_user;

	/**
	 * 词条推荐类的构造函数
	 * @param array $params 
	 * 					-- access_token 用户的授权码
	 * 					-- uid 用户ID
	 */
	function __construct($params)
	{
		$ci = & get_instance();
		$ci->load->helper('Hit_config');
		$ci->load->model('Hit_AbbreviationModel');
		$this->_abbreviater = $ci->Hit_AbbreviationModel;

		if(isset($params['access_token']) && $param['access_token'] != '') {
			$ci->load->library('Hit_SaeTClient');
			$this->_saetclient = $ci->hit_saetclient;
		}

		if(isset($params['uid']) && $params['uid'] != ''){
			$this->_uid = $params['uid'];
		} else if($this->_saetclient) {
			$this->_uid = $this->_saetclient->get_uid();
		}

		$ci->load->model('Hit_UserModel', array('uid'=>$this->_uid));
		$this->_user = $ci->Hit_UserModel;
	}

	/**
	 * 在用户刚登录系统时，进行推荐计算
	 * @return bool 推荐成功返回true
	 */
	public function recommend_when_login()
	{
		if($this->_saetclient) {
			$ci = & get_instance();
			$ci->load->model('Hit_WeibomsgModel');
			$ci->load->model('Hit_AbbreWeibomsgModel');
			$ci->load->helper('Hit_weibo_api');
			$ci->load->helper('date');

			// 构造知识词条的键值对
			$query_result = $ci->hit_abbreviationmodel->get_abbreviations(array('kl','abrid'));
			$ary_knowledge = array();
			foreach($query_result as $row) {
				$ary_knowledge[$row->kl] = $row->abrid;
			}

			// 获取用户最新的若干微博
			$max_status =  get_config_value('max_status_count_login_recommend');
			$ary_statuses = $this->_saetclient->get_friends_timeline($max_status);


			/** bof 匹配微博中是否存在知识条目，并对数据库作相应修改 **/
			// 用于保存插入或者更新的数据
			$ary_status_batch = array();
			$ary_mapping_batch = array();
			$ary_knowledge_batch = array();

			// 查询微博是否包含知识词条
			foreach($ary_statuses as $status) {				
				// 微博是否已经加入 ary_status_batch 的标识
				$status_added = FALSE;

				$status['text'] = get_integrated_status($status);
				foreach($ary_knowledge as $kl=>$abrid) {
					if(stripos($status['text'], $kl)) { //微博包含词条
						if(!$status_added) { // 加入待写入 weibomsg 的数据
							$retweeted_id = isset($status['retweeted_status'])?$status['retweeted_status']['mid']:'NULL';
							$status['created_at'] = standard_date('DATE_ATOM', $status['created_at']);
							$ary_status_batch[] = array(
													'mid' => $status['mid'],
													'uid' => $status['user']['uid'],
													'un' => $status['user']['name'],
													'sn' => $status['user']['screen_name'],
													'iu' => $status['profile_image_url'],
													'rmid' => $retweeted_id,
													'mc' => $status['text'],
													'murl' => NULL,
													'srn' => $status['source'],
													'iurl' => NULL,
													'aurl' => NULL,
													'vurl' => NULL,
													'rc' => $status['reposts_count'],
													'cc' => $status['comments_count'],
													'pt' => $status['created_at'],
													'nc' => NULL
													);
						}

						// 加入待写入 abbre_weibomsg 的数据
						$ary_mapping_batch[] = array(
												'abrid' => $abrid,
												'mid' => $status['mid']
												);

						// 加入待修改的 abbreviation 的abrid
						$ary_knowledge_batch[$abrid] = 1;
					}
				}
			}

			/** bof 修改数据库相应数据 **/
			// 更新 abbreviation 中相应词条的mt为当前时间
			if(sizeof($ary_knowledge_batch) > 0) {
				$modify = array('mt', standard_date('DATE_ATOM'));
				$condition = ' abrid IN (' . implode(',', arry_keys($ary_knowledge_batch));
				$ci->hit_abbreviationmodel->update();
			}
			// 插入数据到 weibomsg 数据库表
			$ci->hit_weibomsgmodel->insert_batch($ary_status_batch);
			// 插入数据到 abbre_weibomsg 数据库表
			$ci->hit_abbreweibomsgmodel->insert_batch($ary_mapping_batch);

			return TRUE;
		}
		return FALSE;
	}

	/**
	 * main 页展示的词条
	 * @param  integer $pageindex 第几页
	 * @return array            推荐的词条
	 */
	public function recommend_per_page($pageindex, $category=0, $fui = NULL)
	{
		$pagesize = get_config_value('main_klg_pagination_pagesize');
		$pagesize = (int)$pagesize;

		if( ! $fui) {
			$fui = $this->_user->get_fui();
		}

		$bpos = ($pageindex-1)*$pagesize;
		$conditions = '';
		if($category != 0){
			$conditions = 'cgid=' . $category;
		}
		$ary_abbres = $this->_abbreviater->select_user_relate( array(
					'fields' => 'abrid,kl,pt,wk,bk,bf',
					'conditions' => $conditions,
					'fui' => $fui,
					'orderby' => array('mt'=>'DESC'),
					'limit' => array($bpos, $pagesize)
					));
		return $ary_abbres;
	}

	/**
	 * search 页每页展示微博
	 * @param  integer $pageindex 页码
	 * @return array            获取的词条
	 */
	public function recommend_search_per_page($pageindex, $key_word)
	{
		$pagesize = get_config_value('search_klg_pagesize');
		$pagesize = (int)$pagesize;

		$bpos = ($pageindex-1)*$pagesize;
		$ary_abbres = $this->_abbreviater->select( array(
					'fields' => 'abrid,kl,pt,wk,bk,bf',
					'like' => array('likes'=>array('kl'=>$key_word),'type'=>'both'),
					'orderby' => array('mt'=>'DESC'),
					'limit' => array($bpos, $pagesize)
					));
		return $ary_abbres;
	}

	/**
	 * box_right 展示的词条
	 * @param  integer $pageindex 第几页
	 * @return array            推荐的词条
	 */
	public function recommend_right_navig($pageindex)
	{
		$pagesize = get_config_value('right_box_pagination_pagesize');
		$pagesize = (int)$pagesize;

		$ary_abbres = $this->_abbreviater->select( array(
					'fields' => 'abrid,kl',
					'orderby' => array('mt'=>'DESC', 'pt'=>'DESC', 'abrid'=>'DESC'),
					'limit' => array(($pageindex-1)*$pagesize, $pagesize)
					));
		return $ary_abbres;
	}

	/**
	 * 推荐相关词条
	 * @param  integer $abrid 原始词条ID
	 * @param  integer $count 推荐词条数量
	 * @return array        推荐词条
	 */
	public function recommend_relate_abbre($abrid, $count)
	{
		$relate_abbres = $this->_abbreviater->select( array(
					'fields' => 'abrid, kl',
					'conditions' => 'abrid IN (SELECT tabrid FROM `abbre_abbre` WHERE oabrid='.$abrid.')',
					'limit' => $count
					));
		return $relate_abbres;
	}
}