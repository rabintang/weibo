<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系统主页面
 */
class Main extends Hit_Controller
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
		$this->load->model('Hit_EntryModel');
		$this->load->model('Hit_UserModel', array('uid'=>get_session('uid')));
		$this->load->library('Hit_EntryRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_BlogRecommender');
		
		// 获取URL参数
		$category = $this->uri->segment(Main::INDEX_CATEGORY, 0);
		$lpagenum = $this->uri->segment(Main::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Main::INDEX_RPAGENUM, 1);
		
		$fui = $this->Hit_UserModel->fui();
		
		// 设置分页
		$conditions = '';
		if($category != 0){
			$conditions = 'categoryid=' . $category;
		}
		$total_rows = $this->Hit_EntryModel->getCorrelateEntryCount(array('fui'=>$fui,'conditions'=>$conditions));
		$url_template = 'main/index/' . $category . '/{%s}/' . $rpagenum;
		$params = array(
			'url_template' => site_url($url_template),
			'total_rows' => $total_rows,
			'pagesize' => get_config_value('MAIN_ENTRY_PAGESIZE'),
			'cur_page' => $lpagenum
		);
		$this->load->library('Hit_Pagination', $params);
		$pagination = $this->hit_pagination->generatePagination();

		// 构造首页展示的词条列表
		$MAIN_CORRELATE_BLOGS_COUNT = get_config_value('MAIN_CORRELATE_BLOGS_COUNT');
		$MAIN_CORRELATE_BLOGGERS_COUNT = get_config_value('MAIN_CORRELATE_BLOGGERS_COUNT');
		$MAIN_CORRELATE_ENTRY_COUNT = get_config_value('MAIN_CORRELATE_ENTRY_COUNT');
		$mainpage_entries = $this->hit_entryrecommender->getMainPageEntries($lpagenum, $category, $fui);
		$mainpage_items = array();
		if( $mainpage_entries && is_array($mainpage_entries) && count($mainpage_entries) > 0){
			foreach($mainpage_entries as $entry){
				$blogs = $this->hit_blogrecommender->getMainPageCorrelateBlogs($entry['entryid'], 
					$MAIN_CORRELATE_BLOGS_COUNT, $fui);
				$bloggers = $this->hit_blogrecommender->getCorrelateBloggers($entry['entryid'], $MAIN_CORRELATE_BLOGGERS_COUNT);
				$correlate_entries = $this->hit_entryrecommender->getCorrelateEntries($entry['entryid'], 
					$MAIN_CORRELATE_ENTRY_COUNT);
				$mainpage_items[] = array(
					'entry'=>$entry, 
					'blogs'=>$blogs,
					'bloggers'=>$bloggers,
					'correlate_entries'=>$correlate_entries
				);
			}
		}
		
		# 首页的TOP N推荐
		$recommend_top_n = get_session('recommend_top_n');
		if($recommend_top_n == 'true'){
			$recommend_entries = $this->Hit_entryrecommender->recommendTopN();			
			$this->session->set_userdata('recommend_top_n', 'false');
			$this->Hit_UserModel->updateLogoutTime();
			$top_n_entries = array();
			foreach($recommend_entries as $entry){
				$blogs = $this->hit_blogrecommender->getMainPageCorrelateBlogs($entry['entryid'], 
					$MAIN_CORRELATE_BLOGS_COUNT, $fui);
				$bloggers = $this->hit_blogrecommender->getCorrelateBloggers($entry['entryid'], $MAIN_CORRELATE_BLOGGERS_COUNT);
				$correlate_entries = $this->Hit_entryrecommender->getCorrelateEntries($entry['entryid'], 
					$MAIN_CORRELATE_ENTRY_COUNT);
				$top_n_entries[] = array(
					'entry'=>$entry, 
					'blogs'=>$blogs,
					'bloggers'=>$bloggers,
					'correlate_entries'=>$correlate_entries
				);
			}
		}

		# 获取页面右侧模块
		$right_box = get_right_box($rpagenum);

		# 页面展示
		$data = array(
			'pagination' => $pagination,
			'items' => $mainpage_items,
			'right_box' => $right_box
		);
		if( isset($top_n_entries) && count($top_n_entries) > 0 ){
			$data['top_n'] = $top_n_entries;
		}
		$this->load->auto_view('main', $data);
	}
}
