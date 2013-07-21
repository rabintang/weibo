<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系统主页面
 */
class Detail extends CI_Controller
{
	// 参数在URL中的位置(第几段)
	const INDEX_ABRID = 3;
	const INDEX_TYPE = 4;
	const INDEX_LPAGENUM = 5;
	const INDEX_RPAGENUM = 6;

	function __construct()
	{
		parent::__construct();

		$this->load->helper('Hit_session');
		$this->load->helper('Hit_config');
	}

	public function index()
	{
		$this->load->model('Hit_AbbreviationModel');
		$this->load->model('Hit_WeibomsgModel');
		$this->load->model('Hit_OutSourceModel');
		$this->load->model('Hit_UserModel', array('uid'=>get_session('uid')));
		$this->load->library('Hit_KlgRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_WbRecommender');

		// 获取URL参数
		$type = $this->uri->segment(Detail::INDEX_TYPE, 0);
		$lpagenum = $this->uri->segment(Detail::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Detail::INDEX_RPAGENUM, 1);
		$abrid = $this->uri->segment(Detail::INDEX_ABRID);
		if( ! $abrid) {
			show_404($this->uri->uri_string(), '请检查您输入的词条编号是否正确');
		}

		// 设置分页
		$conditions = "mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid={$abrid})";
		if($type != 0){ // 查看关注用户的微博
			$fui = $this->Hit_UserModel->get_fui();
			$conditions .= " AND uid IN ({$fui})";
		}
		$total_rows = $this->Hit_WeibomsgModel->get_rows_num(array('conditions'=>$conditions), FALSE);
		$url_template = implode('/', array('detail','index',$abrid,$type,'{%s}',$rpagenum));
		$config = array(
					'url_template' => site_url($url_template),
					'total_rows' => $total_rows,
					'pagesize' => get_config_value('detail_wb_pagination_pagesize'),
					'cur_page' => $lpagenum
					);
		$this->load->library('Hit_Pagination',$config);
		$str_pagination = $this->hit_pagination->create_links();

		// 构造待传递参数
		$relate_resource_count = get_config_value('detail_max_relate_resource');
		$relate_blogger_count = get_config_value('detail_max_relate_blogger');
		$relate_abbre_count = get_config_value('detail_max_relate_abbre');
		$status_pagesize = get_config_value('detail_wb_pagination_pagesize');

		$abbre = $this->Hit_AbbreviationModel->select(array('conditions'=>"abrid={$abrid}",'limit'=>1), FALSE);
		if(count($abbre) > 0){
			$abbre = $abbre[0];
		} else {
			show_404($this->uri->uri_string(), '请检查您输入的词条编号是否正确');
		}
		$ary_blogger = $this->hit_wbrecommender->recommend_blogger($abrid, $relate_blogger_count);
		$ary_relate_abbres = $this->hit_klgrecommender->recommend_relate_abbre($abrid, $relate_abbre_count);
		$ary_relate_resource = $this->Hit_OutSourceModel->select_abbre_relate(array('abrid'=>$abrid,'limit'=>$relate_resource_count));
		if($type != 0){
			$ary_status = $this->hit_wbrecommender->recommend_status($abrid, ($lpagenum-1)*$status_pagesize, $status_pagesize, $fui);
		} else {
			$ary_status = $this->hit_wbrecommender->recommend_status($abrid, ($lpagenum-1)*$status_pagesize, $status_pagesize);
		}
		$box_right = get_box_right($rpagenum);
		$data = array(
					'abbre'=>$abbre, 
					'statuses'=>$ary_status,
					'bloggers'=>$ary_blogger,
					'relate_abbres'=>$ary_relate_abbres,
					'relate_resources'=>$ary_relate_resource,					
					'pagination' => $str_pagination,
					'box_right' => $box_right
					);		

		$this->load->auto_view('detail', $data);
	}
}