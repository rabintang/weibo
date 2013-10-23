<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与微博推荐相关的方法
 */

class Hit_WbRecommender
{
	private $_weibo;

	function __construct()
	{
		$ci = & get_instance();
		$ci->load->model('Hit_WeibomsgModel');
		$this->_weibo = $ci->Hit_WeibomsgModel;
		$ci->load->helper('Hit_datetime');
		$ci->load->helper('Hit_config');
	}

	/**
	 * 推荐 main 页的微博
	 * @param  integer $abrid 词条ID
	 * @param  integer $count 微博数
	 * @return array        词条列表
	 */
	public function recommend_brif($abrid, $count, $fui)
	{
		$CI = & get_instance();
		$friend_time_interval = (int)get_config_value('friend_time_interval') * -1;
		$conditions = "uid IN (" . $fui . ") AND mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid="
				. $abrid . ") ";
		if($friend_time_interval != 0){
			$conditions = $conditions . " AND pt>='" . add_interval($friend_time_interval) . "'";
		}
		
		$ary_wb = $this->_weibo->select(array(
			'fields' => 'mid,uid,sn,mc,murl,pt',
			'conditions' => $conditions,
			'groupby' => 'mid',
			'orderby' => array('pt'=>'DESC','mid'=>'DESC'),
			'limit' => $count
		));

		
		if(count($ary_wb) < $count){
			$mids = '';
			$common_time_interval = (int)get_config_value('common_time_interval') * -1;
			$count = $count - count($ary_wb);
			if(count($ary_wb) > 0){
				$mids = "mid NOT IN ('";
				foreach($ary_wb as $wb){
					$mids .= $wb['mid'] . "','";
				}
				$mids = rtrim($mids, ',');
				$mids .= "') AND ";
			}
			$conditions = $mids . "mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=" 
				. $abrid . ") ";
			if($common_time_interval != 0){
				$conditions = $conditions . " AND pt>='" . add_interval($common_time_interval) . "'";
			}
			$ary_wb_2 = $this->_weibo->select( array(
				'fields' => 'mid,uid,sn,mc,murl,pt',
				'conditions' => $conditions,
				'groupby' => 'mid',
				'orderby' => array('pt'=>'DESC','mid'=>'DESC'),
				'limit' => $count
				), False );
			$ary_wb = array_merge($ary_wb, $ary_wb_2);
		}
		$ary_wb_brif = array();
		foreach($ary_wb as $wb){
			$ary_wb_brif[] = $this->handle_wbmsg($wb);
		}
		return $ary_wb_brif;
	}

	/**
	 * detail 页微博列表
	 * @param  integer  $abrid 词条ID
	 * @param  integer $bpos  微博起始编号
	 * @param  integer $count 获取微博数
	 * @param  string  $fui   用户关注好友ID列表
	 * @return array         微博列表
	 */
	public function recommend_status($abrid, $bpos=0, $count=10, $fui=NULL)
	{
		$conditions = "mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid={$abrid})";
		if($fui && ! empty($fui)){
			$conditions .= " AND uid IN ({$fui})";
		}
		$ary_status = $this->_weibo->select(array(
					'fields' => 'mid,uid,sn,iu,mc,murl,srn,rc,cc,pt',
					'conditions' => $conditions,
					'orderby' => array('pt'=>'DESC'),
					'limit' => array($bpos,$count)
					));
		return $ary_status;
	}

	/**
	 * 推荐词条相关博主
	 * @param  integer $abrid 词条ID
	 * @param  integer $count 推荐博主数
	 * @return array        博主
	 */
	public function recommend_blogger($abrid, $count)
	{
		$ary_blogger = $this->_weibo->select(array(
					'fields' => 'uid,sn',
					'conditions' => "mid in (SELECT mid FROM `abbre_weibomsg` WHERE abrid={$abrid}) AND sn!=''",
					'groupby' => 'uid',
					'limit' => $count
					));
		return $ary_blogger;
	}

	/**
	 * 对微博内容的处理
	 * @param  array $row 微博数组
	 * @param  string $kl  词条名称
	 * @return string      处理好的词条字符串
	 */
	private function handle_wbmsg($row, $kl=NULL)
	{
		$CI = & get_instance();
		$CI->load->helper('Hit_string');
		$totallen = get_config_value('main_wb_item_length');
		if( ! $totallen ){
			$totallen = 110; //The length of a line(including screen name, microblog message, publish time).
		}
		$restlen = $totallen - UTF8_length($row["sn"]) - strlen($row['pt']);
		$str = "<div class='weibo'><div class='weibo_blogger'><a href='http://www.weibo.com/{$row["uid"]}'";
		$str = $str." target='_blank'>{$row["sn"]}</a>: </div><div class='weibo_content'><span>";
		if(UTF8_length($row['mc']) > $restlen){
			$str .= UTF8_substr($row['mc'],0,$restlen) . '...';
		} else {
			$str .= $row['mc'];
		}
		if(!empty($row['murl'])){
			$str = $str."<a href='{$row["murl"]}' target='_blank'><font color='#0082D1'>[详见]</font></a>";
		}
		$str = $str."</span></div>";
		if(!empty($row['pt'])){
			$str = $str."<div class='weibo_time'><span>{$row["pt"]}</span></div>";
		}
		$str = $str.'</div>';
		return $str;
	}
}
