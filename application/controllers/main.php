<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系统主页面
 */
class Main extends CI_Controller
{
	// 参数在URL中的位置(第几段)
	const INDEX_CATEGORY = 3;
	const INDEX_LPAGENUM = 4;
	const INDEX_RPAGENUM = 5;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('Hit_session');
		$this->load->helper('Hit_config');
	}

	public function index()
	{
		$this->load->model('Hit_AbbreviationModel');
		$this->load->model('Hit_UserModel', array('uid'=>get_session('uid')));
		$this->load->library('Hit_KlgRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_WbRecommender');

		// 获取URL参数
		$category = $this->uri->segment(Main::INDEX_CATEGORY, 0);
		$lpagenum = $this->uri->segment(Main::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Main::INDEX_RPAGENUM, 1);

		$fui = $this->Hit_UserModel->get_fui();
		
		// 设置分页
		$conditions = '';
		if($category != 0){
			$conditions = 'cgid=' . $category;
		}
		$total_rows = $this->Hit_AbbreviationModel->get_relate_rows_num(array('fui'=>$fui,'conditions'=>$conditions));
		$url_template = 'main/index/' . $category . '/{%s}/' . $rpagenum;
		$params = array(
					'url_template' => site_url($url_template),
					'total_rows' => $total_rows,
					'pagesize' => get_config_value('main_klg_pagination_pagesize'),
					'cur_page' => $lpagenum
					);
		$this->load->library('Hit_Pagination',$params);
		$str_pagination = $this->hit_pagination->create_links();

		// 构造待传递参数
		$relate_status_count = get_config_value('main_max_relate_status');
		$relate_blogger_count = get_config_value('main_max_relate_blogger');
		$relate_abbre_count = get_config_value('main_max_relate_abbre');
		$ary_abbres = $this->hit_klgrecommender->recommend_per_page($lpagenum, $category, $fui);
		$ary_items = array();
		foreach($ary_abbres as $abbre){
			$ary_wb_brif = $this->hit_wbrecommender->recommend_brif($abbre['abrid'], $relate_status_count, $fui);
			$ary_blogger = $this->hit_wbrecommender->recommend_blogger($abbre['abrid'], $relate_blogger_count);
			$ary_relate_abbres = $this->hit_klgrecommender->recommend_relate_abbre($abbre['abrid'], $relate_abbre_count);
			$ary_items[] = array(
							'abbre'=>$abbre, 
							'wb_brif'=>$ary_wb_brif,
							'bloggers'=>$ary_blogger,
							'relate_abbres'=>$ary_relate_abbres
							);
		}
		$box_right = get_box_right($rpagenum);
		$data = array(
					'pagination' => $str_pagination,
					'items' => $ary_items,
					'box_right' => $box_right
					);

		$this->load->auto_view('main', $data);
	}
}
