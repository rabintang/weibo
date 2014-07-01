<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与微博推荐相关的方法
 */

class Hit_BlogRecommender
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
	 * main 页各词条对应的的相关微博
	 * @param  integer $entryid 词条ID
	 * @param  integer $count 微博数
	 * @return array        词条列表
	 */
	public function getMainPageCorrelateBlogs($entryid, $count, $fui)
	{
		$CI = & get_instance();
		$FRIEND_BLOG_PUBLISHTIME_LIMIT = (int)get_config_value('FRIEND_BLOG_PUBLISHTIME_LIMIT') * -1;
		$conditions = "uid IN (" . $fui . ") AND mid IN (SELECT mid FROM `correlateweibo` WHERE entryid="
				. $entryid . ") ";
		if($FRIEND_BLOG_PUBLISHTIME_LIMIT != 0){
			$conditions = $conditions . " AND pt>='" . add_interval($FRIEND_BLOG_PUBLISHTIME_LIMIT) . "'";
		}
		
		$blogs = $this->_weibo->select(array(
			'fields' => 'mid,uid,un,mc,page,pt',
			'conditions' => $conditions,
			'groupby' => 'mid',
			'orderby' => array('pt'=>'DESC','mid'=>'DESC'),
			'limit' => $count
		));

		
		if(count($blogs) < $count){
			$mids = '';
			$GLOBAL_BLOG_PUBLISHTIME_LIMIT = (int)get_config_value('GLOBAL_BLOG_PUBLISHTIME_LIMIT') * -1;
			$count = $count - count($blogs);
			if(count($blogs) > 0){
				$mids = "mid NOT IN ('";
				foreach($blogs as $blog){
					$mids .= $blog['mid'] . "','";
				}
				$mids = rtrim($mids, ',');
				$mids .= "') AND ";
			}
			$conditions = $mids . "mid IN (SELECT mid FROM `correlateweibo` WHERE entryid=" 
				. $entryid . ") ";
			if($GLOBAL_BLOG_PUBLISHTIME_LIMIT != 0){
				$conditions = $conditions . " AND pt>='" . add_interval($GLOBAL_BLOG_PUBLISHTIME_LIMIT) . "'";
			}
			$compensate_blogs = $this->_weibo->select( array(
				'fields' => 'mid,uid,un,mc,page,pt',
				'conditions' => $conditions,
				'groupby' => 'mid',
				'orderby' => array('pt'=>'DESC','mid'=>'DESC'),
				'limit' => $count
				), False );
			$blogs = array_merge($blogs, $compensate_blogs);
		}
		$decorated_blogs = array();
		foreach($blogs as $blog){
			$decorated_blogs[] = $this->decorateBlog($blog);
		}
		return $decorated_blogs;
	}

	/**
	 * detail 页微博列表
	 * @param  integer  $entryid 词条ID
	 * @param  integer $offset  微博起始编号
	 * @param  integer $count 获取微博数
	 * @param  string  $fui   用户关注好友ID列表
	 * @return array         微博列表
	 */
	public function getDetailPageCorrelateBlogs($entryid, $offset=0, $count=10, $fui=NULL)
	{
		$conditions = "mid IN (SELECT mid FROM `correlateweibo` WHERE entryid={$entryid})";
		if($fui && ! empty($fui)){
			$conditions .= " AND uid IN ({$fui})";
		}
		$blogs = $this->_weibo->select(array(
					'fields' => 'mid,uid,un,iu,mc,page,srn,rc,cc,pt',
					'conditions' => $conditions,
					'orderby' => array('pt'=>'DESC'),
					'limit' => array($offset,$count)
					));
		return $blogs;
	}

	/**
	 * 推荐词条相关博主
	 * @param  integer $entryid 词条ID
	 * @param  integer $count 推荐博主数
	 * @return array        博主
	 */
	public function getCorrelateBloggers($entryid, $count)
	{
		$bloggers = $this->_weibo->select(array(
					'fields' => 'uid,un',
					'conditions' => "mid in (SELECT mid FROM `correlateweibo` WHERE entryid={$entryid}) AND un!=''",
					'groupby' => 'uid',
					'limit' => $count
					));
		return $bloggers;
	}

	/**
	 * 对微博内容的处理
	 * @param  array $row 微博数组
	 * @param  string $kl  词条名称
	 * @return string      处理好的词条字符串
	 */
	private function decorateBlog($row, $kl=NULL)
	{
		$CI = & get_instance();
		$CI->load->helper('Hit_string');
		$totallen = get_config_value('main_wb_item_length');
		if( ! $totallen ){
			$totallen = 110; //The length of a line(including screen name, microblog message, publish time).
		}
		$restlen = $totallen - UTF8_length($row["un"]) - strlen($row['pt']);
		$str = "<div class='weibo'><div class='weibo_blogger'><a href='http://www.weibo.com/{$row["uid"]}'";
		$str = $str." target='_blank'>{$row["un"]}</a>: </div><div class='weibo_content'><span>";
		if(UTF8_length($row['mc']) > $restlen){
			$str .= UTF8_substr($row['mc'],0,$restlen) . '...';
		} else {
			$str .= $row['mc'];
		}
		if(!empty($row['page'])){
			$str = $str."<a href='{$row["page"]}' target='_blank'><font color='#0082D1'>[详见]</font></a>";
		}
		$str = $str."</span></div>";
		if(!empty($row['pt'])){
			$str = $str."<div class='weibo_time'><span>{$row["pt"]}</span></div>";
		}
		$str = $str.'</div>';
		return $str;
	}
}
