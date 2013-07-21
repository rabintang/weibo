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
if( ! function_exists('get_box_right'))
{
	function get_box_right($pagenum)
	{
		$CI = & get_instance();
		$CI->load->library('Hit_KlgRecommender');
		$ary_abbres_right = $CI->hit_klgrecommender->recommend_right_navig($pagenum);

		if( ! $CI->session->userdata('user')){
			$CI->load->model('Hit_UserModel', array('uid'=>$CI->session->userdata('uid')));
			$user = $CI->Hit_UserModel->select(array(
						'fields'=>'uid,sn,sx,vi,dr,bl,de,ad,un,an,fn,mn,iu,iv,tg,rn', 
						'conditions'=>array('uid'=>$CI->session->userdata('uid')),
						'limit'=>1));
			if(sizeof($user) > 0){
				$CI->session->set_userdata('user',$user[0]);
			}
		}
		return $CI->load->view('modules/box_right', array('abbres'=>$ary_abbres_right), TRUE);
	}
}

/**
 * 获取右侧导航的URL
 * @param  integer $pagenum 页码数
 * @param  integer $direct  向上翻页(0)/向下翻页(1)
 * @return string          成功返回URL,失败返回false
 */
if( ! function_exists('get_rnavigurl'))
{
	function get_rnavigurl($direct)
	{
		$CI = & get_instance();
		$CI->load->helper('url');
		$pagenum = $CI->uri->segment(5, 1);
		$url = $CI->uri->uri_string();
		$url = substr($url, 0, strrpos($url, '/'));
		if($direct == 0){
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
 * @param  string $wk 维基百科链接 
 * @param  string $bk 百度百科链接
 * @return string        输出内容
 */
if( ! function_exists('get_wk_bk'))
{
	function get_wk_bk($wk, $bk)
	{
		if(!empty($wk) || !empty($bk)) {
			$str = "<div class='relate_link'><span >相关链接: </span>";
		} else {
			return '';
		}
		if(!empty($wk)) {
			$str = $str."<a href='{$wk}' target='_blank'>维基百科释义</a>";
			if(!empty($bk)) {
				$str = $str."<span class='split_font'> | </span><a href='{$bk}' target='_blank'>百度百科释义</a>";
			}
		} else {
			$str = $str."<a href='{$bk}' target='_blank'>百度百科释义</a>";
		}
		$str = $str."</div>";
		return $str;
	}
}

/**
 * 获取词条相关博主的输出
 * @param  array $bloggers 博主列表
 * @return string           界面输出
 */
if( ! function_exists('get_relate_blogger'))
{
	function get_relate_blogger($bloggers)
	{
		$str = '';
		if(is_array($bloggers) && count($bloggers) > 0) {
			$first_flag = TRUE;
			foreach($bloggers as $blogger){
				if( ! $first_flag){
					$str .= "<span class='split_font'> | </span>";
				}
				$str .= "<a href='http://www.weibo.com/{$blogger["uid"]}' target='_blank'>@{$blogger["sn"]}</a>";
				$first_flag = FALSE;
			}
			$str .= "...";
		}
		return $str;
	}
}

/**
 * 获取相关词条的输出
 * @param  array $abbres 相关词条列表
 * @return string         相关词条输出
 */
if( ! function_exists('get_relate_abbres'))
{
	function get_relate_abbres($abbres)
	{
		$str = '';
		if(is_array($abbres) && count($abbres) > 0) {
			$str .= "<div class='relate_voc'><span>相关词条: </span>";
			$first_flag = TRUE;
			foreach($abbres as $relate_abbre){
				if( ! $first_flag) {
					$str .= '<span class="split_font"> | </span>';
				}
				$first_flag = FALSE;
				$str .= "<a href='". site_url("detail/index/{$relate_abbre['abrid']}") . "'>{$relate_abbre['kl']}</a>";
			}
			$str .= '</div>';
		}
		return $str;
	}
}