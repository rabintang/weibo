<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 与视图相关的一些函数
 */

/**
 * 提供在视图中加载视图的功能
 * @param  string  $view 加载的视图名称
 * @param  string/array  $vars 传递给视图的数据
 * @param  boolean $return 
 * @return string 加载的视图输出流
 */
if ( ! function_exists('load_view'))
{	
	function load_view($view, $vars = '', $return = FALSE)
	{
		$CI =& get_instance();
		return $CI->load->view($view, $vars, $return);
	}
}

/**
 * 获取css/js/images 等资源的基础路径
 * @return string 基础路径
 */
if( ! function_exists('get_assets_base_url'))
{
	function get_assets_base_url()
	{
		$CI = & get_instance();
		$CI->load->helper('url');
		return base_url() . 'assets/';
	}
}

/**
 * 获取右侧模块的输出
 * @param  integer $pagenum 词条列表页码
 * @return string          输出的view
 */
if( ! function_exists('get_right_box'))
{
	function get_right_box($pagenum)
	{
		$CI = & get_instance();
		$CI->load->library('Hit_EntryRecommender');
		$entries = $CI->hit_entryrecommender->recommendRightHand($pagenum);

		if( ! $CI->session->userdata('user')){
			$CI->load->model('Hit_UserModel', array('uid'=>$CI->session->userdata('uid')));
			$user = $CI->Hit_UserModel->select(array(
						'fields'=>'uid,un,sx,vi,dr,bl,de,ad,un,an,fn,mn,iu,iv,tg', 
						'conditions'=>array('uid'=>$CI->session->userdata('uid')),
						'limit'=>1));
			if(sizeof($user) > 0){
				$CI->session->set_userdata('user',$user[0]);
			}
		}
		return $CI->load->view('modules/right_box', array('entries'=>$entries), TRUE);
	}
}

/**
 * 获取右侧导航的URL
 * @param  integer $pagenum 页码数
 * @param  integer $direction  向上翻页(0)/向下翻页(1)
 * @return string          成功返回URL,失败返回false
 */
if( ! function_exists('get_navigation_url_righthand'))
{
	function get_navigation_url_righthand($direction)
	{
		$CI = & get_instance();
		$CI->load->helper('url');
		$pagenum = $CI->uri->segment(5, 1);
		$url = $CI->uri->uri_string();
		$url = substr($url, 0, strrpos($url, '/'));
		if($direction == 0){
			$pagenum--;
		} else {
			$pagenum++;
		}
		if($pagenum <= 0){
			$pagenum = 1;
		}
		$url .= '/' . $pagenum;
		return site_url($url);
	}
}

/**
 * 获取词条百科链接输出
 * @param  string $wiki 维基百科链接 
 * @param  string $baike 百度百科链接
 * @return string        输出内容
 */
if( ! function_exists('get_wiki_and_baike'))
{
	function get_wiki_and_baike($wiki, $baike)
	{
		if(!empty($wiki) || !empty($baike)) {
			$html_output = "<div class='relate_link'><span >相关链接: </span>";
		} else {
			return '';
		}
		if(!empty($wiki)) {
			$html_output = $html_output."<a href='{$wiki}' target='_blank'>维基百科释义</a>";
			if(!empty($baike)) {
				$html_output = $html_output."<span class='split_font'> | </span><a href='{$baike}' target='_blank'>百度百科释义</a>";
			}
		} else {
			$html_output = $html_output."<a href='{$baike}' target='_blank'>百度百科释义</a>";
		}
		$html_output = $html_output."</div>";
		return $html_output;
	}
}

/**
 * 获取词条相关博主的输出
 * @param  array $correlate_bloggers 博主列表
 * @return string           界面输出
 */
if( ! function_exists('get_correlate_bloggers'))
{
	function get_correlate_bloggers($correlate_bloggers)
	{
		$html_output = '';
		if(is_array($correlate_bloggers) && count($correlate_bloggers) > 0) {
			$is_first = TRUE;
			foreach($correlate_bloggers as $blogger){
				if( ! $is_first){
					$html_output .= "<span class='split_font'> | </span>";
				}
				$html_output .= "<a href='http://www.weibo.com/{$blogger["uid"]}' target='_blank'>@{$blogger["un"]}</a>";
				$is_first = FALSE;
			}
			$html_output .= "...";
		}
		return $html_output;
	}
}

/**
 * 获取相关词条的输出
 * @param  array $correlate_entries 相关词条列表
 * @param  string $source 词条的来源，是TopN推荐，还是主页列表页的
 * @return string         相关词条输出
 */
if( ! function_exists('get_correlate_entries'))
{
	function get_correlate_entries($correlate_entries, $source)
	{
		$html_output = '';
		if(is_array($correlate_entries) && count($correlate_entries) > 0) {
			$html_output .= "<div class='relate_voc'><span>相关词条: </span>";
			$is_first = TRUE;
			foreach($correlate_entries as $corrlate_entry){
				if( ! $is_first ) {
					$html_output .= '<span class="split_font"> | </span>';
				}
				$is_first = FALSE;
				$html_output .= "<a onclick=\"javascript:recordAction('" . site_url("detail/index/" .
						$corrlate_entry['entryid']) . "', '" . $source . "relate');return false;\">{$corrlate_entry['name']}</a>";
			}
			$html_output .= '</div>';
		}
		return $html_output;
	}
}
