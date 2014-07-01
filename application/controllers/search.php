<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 搜索结果页
 */
class Search extends Hit_Controller
{
	const INDEX_LPAGENUM = 3;
	const INDEX_RPAGENUM = 4;
	const INDEX_KEYWORD = 5;

	function __construct()
	{
		parent::__construct();

		$this->load->helper('Hit_config');
	}

	public function index()
	{
		$this->load->model('Hit_EntryModel');
		$keyword = $this->input->post('word');

		if( ! $keyword){ // 跳转到404
			show_404('关键词不能为空');
		}

		$rows_num = $this->Hit_EntryModel->getRowsNum(array(
					'like' => array('likes'=>array('name'=>$keyword),'type'=>'both')
					));

		$data = array(
					'keyword' => $keyword
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
		$this->load->library('Hit_EntryRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_BlogRecommender');

		// 获取URL参数
		$lpagenum = $this->uri->segment(Search::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Search::INDEX_RPAGENUM, 1);

		$fui = $this->Hit_UserModel->fui();
		
		// 设置分页
		$total_rows = $data['total_rows'];
		$url_template = implode('/',array('search','index','{%s}',$rpagenum));
		$params = array(
					'url_template' => site_url($url_template),
					'total_rows' => $total_rows,
					'pagesize' => get_config_value('SEARCH_ENTRY_PAGESIZE'),
					'cur_page' => $lpagenum
					);
		$this->load->library('Hit_Pagination',$params);
		$pagination = $this->hit_pagination->generatePagination();

		// 构造待传递参数
		$entries = $this->hit_entryrecommender->recommendSearchPageEntries($lpagenum, $data['keyword']);
		$items = array();
		foreach($entries as $entry){
			$blogs = $this->hit_blogrecommender->getMainPageCorrelateBlogs($entry['entryid'], 
				get_config_value('MAIN_CORRELATE_BLOGS_COUNT'), $fui);
			$bloggers = $this->hit_blogrecommender->getCorrelateBloggers($entry['entryid'], 
				get_config_value('MAIN_CORRELATE_BLOGGERS_COUNT'));
			$correlate_entries = $this->hit_entryrecommender->getCorrelateEntries($entry['entryid'], 
				get_config_value('MAIN_CORRELATE_ENTRY_COUNT'));
			$items[] = array(
							'entry'=>$entry,
							'blogs'=>$blogs,
							'bloggers'=>$bloggers,
							'correlate_entries'=>$correlate_entries
							);
		}
		$right_box = get_right_box($rpagenum);
		$data['pagination'] = $pagination;
		$data['items'] = $items;
		$data['right_box'] = $right_box;
		$this->load->auto_view('found', $data);
	}

	protected function nofound($data=array())
	{
		$this->load->auto_view('nofound', $data);
	}
}