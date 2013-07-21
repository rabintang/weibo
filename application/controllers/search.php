<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 搜索结果页
 */
class Search extends CI_Controller
{
	const INDEX_LPAGENUM = 3;
	const INDEX_RPAGENUM = 4;
	const INDEX_KEYWORD = 5;

	function __construct()
	{
		parent::__construct();

		$this->load->helper('Hit_session');
		$this->load->helper('Hit_config');

		$this->session->set_userdata('uid', '2100610530');
	}

	public function index()
	{
		$this->load->model('Hit_AbbreviationModel');
		$key_word = $this->input->post('word');
		if( ! $key_word) {
			$key_word = get_session('key_word');
		}
		if( ! $key_word){ // 跳转到404
			show_404('关键词不能为空');
		} else {
			$this->session->set_userdata('key_word', $key_word);
		}

		$rows_num = $this->Hit_AbbreviationModel->get_rows_num(array(
					'like' => array('likes'=>array('kl'=>$key_word),'type'=>'both')
					));

		$data = array(
					'key_word' => $key_word
					);

		if($rows_num > 0){
			$data['total_rows'] = $rows_num;
			$this->found($data);
		} else {
			$this->nofound($data);
		}
	}

	protected function found($data=array())
	{
		$this->load->model('Hit_UserModel', array('uid'=>get_session('uid')));
		$this->load->library('Hit_KlgRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_WbRecommender');

		// 获取URL参数
		$lpagenum = $this->uri->segment(Search::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Search::INDEX_RPAGENUM, 1);

		$fui = $this->Hit_UserModel->get_fui();
		
		// 设置分页
		$total_rows = $data['total_rows'];
		$url_template = implode('/',array('search','index','{%s}',$rpagenum));
		$params = array(
					'url_template' => site_url($url_template),
					'total_rows' => $total_rows,
					'pagesize' => get_config_value('search_klg_pagesize'),
					'cur_page' => $lpagenum
					);
		$this->load->library('Hit_Pagination',$params);
		$str_pagination = $this->hit_pagination->create_links();

		// 构造待传递参数
		$relate_status_count = get_config_value('main_max_relate_status');
		$relate_blogger_count = get_config_value('main_max_relate_blogger');
		$relate_abbre_count = get_config_value('main_max_relate_abbre');
		$ary_abbres = $this->hit_klgrecommender->recommend_search_per_page($lpagenum, $data['key_word']);
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
		$data['pagination'] = $str_pagination;
		$data['items'] = $ary_items;
		$data['box_right'] = $box_right;
		$this->load->auto_view('found', $data);
	}

	protected function nofound($data=array())
	{
		$this->load->auto_view('nofound', $data);
	}
}