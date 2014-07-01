<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 提供给用户推荐词条的各种方法
 */
class Hit_EntryRecommender
{
	private $_uid;
	private $_saetclient;
	private $_entrymodel;
	private $_usermodel;

	/**
	 * 词条推荐类的构造函数
	 * @param array $params 
	 * 	-- access_token 用户的授权码
	 * 	-- uid 用户ID
	 */
	function __construct($params)
	{
		$ci = & get_instance();
		$ci->load->helper('Hit_config');
		$ci->load->model('Hit_EntryModel');
		$ci->load->helper('Hit_string');
		$this->_entrymodel = $ci->Hit_EntryModel;
		
		if(isset($params['access_token']) && $param['access_token'] != '') {
			$ci->load->library('Hit_SaeTClient');
			$this->_saetclient = $ci->hit_saetclient;
		}

		if(isset($params['uid']) && $params['uid'] != ''){
			$this->_uid = (string)$params['uid'];
		} else if($this->_saetclient) {
			$this->_uid = $this->_saetclient->get_uid();
		}

		$ci->load->model('Hit_UserModel', array('uid'=>$this->_uid));
		$this->_usermodel = $ci->Hit_UserModel;
	}

	/**
	 * 在用户刚登录系统时，进行推荐计算
	 * @return bool 推荐成功返回true
	 */
	public function recommendAfterLogin()
	{
		if($this->_saetclient) {
			$ci = & get_instance();
			$ci->load->model('Hit_WeibomsgModel');
			$ci->load->model('Hit_EntryModel');
			$ci->load->helper('Hit_weibo_api');
			$ci->load->helper('date');

			// 构造知识词条的键值对
			$query_result = $ci->hit_entrymodel->get_entrys(array('name','entryid'));
			$entrys = array();
			foreach($query_result as $row) {
				$entrys[$row->name] = $row->entryid;
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
			$ci->hit_weibomsgmodel->insertBatch($ary_status_batch);
			// 插入数据到 abbre_weibomsg 数据库表
			$ci->hit_abbreweibomsgmodel->insertBatch($ary_mapping_batch);

			return TRUE;
		}
		return FALSE;
	}

	/**
	 * main 页用户刚登录时推荐的词条
	 * @param integer $n 推荐的数量
	 * @param string $uid 用户ID
	 */
	public function recommendTopN($n = NULL, $uid = NULL)
	{
		$user_model = $this->_usermodel;
		if($uid == NULL){
			$uid = $this->_uid;
		} else if($uid !== $this->_uid){
			$CI = & get_instance();
			$CI->load->model('Hit_UserModel', array('uid'=>$uid));
			$user_model = $CI->Hit_UserModel;
		} else {
			return NULL;
		}
		      
		if($n == NULL){
			$n = get_config_value('TOPN');
			if( ! $n )
			      $n = 5;
		}

		// 获取用户关注好友微博中的最新词条,按照修改时间排序
		$fui = $user_model->fui();
		$conditions = "modifytime > (SELECT lastlogin FROM `user` WHERE uid='{$uid}')";
		$entries = $this->_entrymodel->selectCorrelateEntries( array(
					'fields' => 'entryid,name,publishtime,wiki,baike,description',
					'conditions' => $conditions,
					'fui' => $fui,
					'orderby' => array('modifytime'=>'DESC'),
					'limit' => $n
					));
	
		// 数量不足时从全体数据库中检索最新词条
		if(count($entries) < $n){
			$entryids = '';
			if(count($entries) > 0){
				$entryids = ' AND entryid NOT IN(';
				foreach($entries as $entry){
					$entryids .= $entry['entryid'] . ',';
				}
				$entryids = rtrim($entryids, ',');
				$entryids .= ") ";
			}
			$conditions = "modifytime > (SELECT lastlogin FROM `user` WHERE uid='{$uid}')" . $abrids;
			$count = $n - count($entries);
			$compensate_entries = $this->_entrymodel->select( array(
					'fields' => 'entryid,name,publishtime,wiki,baike,description',
					'conditions' => $conditions,
					'orderby' => array('modifytime'=>'DESC'),
					'limit' => $count
					) );
			$entries = array_merge($entries, $compensate_entries);
		}
		return $this->decorateSummaries($entries);
	}
	
	private function decorateSummaries($entries)
	{
		$MAIN_ENTRY_SUMMARY_LENGTH = get_config_value('MAIN_ENTRY_SUMMARY_LENGTH');
		if( ! $MAIN_ENTRY_SUMMARY_LENGTH ){
			$MAIN_ENTRY_SUMMARY_LENGTH = 340;
		}
		for($i = 0; $i < count($entries); $i++){
			if(UTF8_length($entries[$i]['description']) > $MAIN_ENTRY_SUMMARY_LENGTH){
				$entries[$i]['description'] = UTF8_substr($entries[$i]['description'], 0, $MAIN_ENTRY_SUMMARY_LENGTH) . ' ... ...';
			}
		}
		return $entries;
	}
	
	/**
	 * main 页展示的词条
	 * @param  integer $pageindex 第几页
	 * @return array            推荐的词条
	 */
	public function getMainPageEntries($pageindex, $category=0, $fui = NULL)
	{
		$MAIN_ENTRY_PAGESIZE = get_config_value('MAIN_ENTRY_PAGESIZE');
		$MAIN_ENTRY_PAGESIZE = (int)$MAIN_ENTRY_PAGESIZE;

		if( ! $fui) {
			$fui = $this->_user->get_fui();
		}

		$offset = ($pageindex-1)*$MAIN_ENTRY_PAGESIZE;
		$conditions = '';
		if($category != 0){
			$conditions = 'categoryid=' . $category;
		}
		$entries = $this->_entrymodel->selectCorrelateEntries( array(
					'fields' => 'entryid,name,publishtime,wiki,baike,description',
					'conditions' => $conditions,
					'fui' => $fui,
					'orderby' => array('modifytime'=>'DESC'),
					'limit' => array($offset, $MAIN_ENTRY_PAGESIZE)
					));
		return $this->decorateSummaries($entries);
	}

	/**
	 * search 页每页展示的词条
	 * @param  integer $pageindex 页码
	 * @return array            获取的词条
	 */
	public function recommendSearchPageEntries($pageindex, $keyword)
	{
		$SEARCH_ENTRY_PAGESIZE = (int)get_config_value('SEARCH_ENTRY_PAGESIZE');

		$offset = ($pageindex-1)*$SEARCH_ENTRY_PAGESIZE;
		$entries = $this->_entrymodel->select( array(
					'fields' => 'entryid,name,publishtime,wiki,baike,description',
					'like' => array('likes'=>array('name'=>$keyword),'type'=>'both'),
					'orderby' => array('modifytime'=>'DESC'),
					'limit' => array($offset, $SEARCH_ENTRY_PAGESIZE)
					));
		return $entries;
	}

	/**
	 * 右边推荐框展示的词条
	 * @param  integer $pageindex 第几页
	 * @return array            推荐的词条
	 */
	public function recommendRightHand($pageindex)
	{
		$RIGHT_HAND_ENTRY_PAGESIZE = (int)get_config_value('RIGHT_HAND_ENTRY_PAGESIZE');

		$entries = $this->_entrymodel->select( array(
					'fields' => 'entryid,name',
					'orderby' => array('modifytime'=>'DESC', 'publishtime'=>'DESC', 'entryid'=>'DESC'),
					'limit' => array(($pageindex-1)*$RIGHT_HAND_ENTRY_PAGESIZE, $RIGHT_HAND_ENTRY_PAGESIZE)
					));
		return $entries;
	}

	/**
	 * 获取与某词条相关的词条
	 * @param  integer $entryid 原始词条ID
	 * @param  integer $count 推荐词条数量
	 * @return array        推荐词条
	 */
	public function getCorrelateEntries($entryid, $count)
	{
		$correlate_entries = $this->_entrymodel->select( array(
					'fields' => 'entryid, name',
					'conditions' => 'entryid IN (SELECT correlateid FROM `correlatentry` WHERE originid='.$entryid.')',
					'limit' => $count
					));
		return $correlate_entries;
	}
}
