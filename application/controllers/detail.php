<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * 系统主页面
 */
class Detail extends Hit_Controller
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
		$this->load->model('Hit_EntryModel');
		$this->load->model('Hit_WeibomsgModel');
		$this->load->model('Hit_ResourceModel');
		$this->load->model('Hit_UserModel', array('uid'=>get_session('uid')));
		$this->load->library('Hit_EntryRecommender', array('uid'=>get_session('uid')));
		$this->load->library('Hit_BlogRecommender');

		// 获取URL参数
		$type = $this->uri->segment(Detail::INDEX_TYPE, 0);
		$lpagenum = $this->uri->segment(Detail::INDEX_LPAGENUM, 1);
		$rpagenum = $this->uri->segment(Detail::INDEX_RPAGENUM, 1);
		$entryid = $this->uri->segment(Detail::INDEX_ABRID);
		if( ! $entryid) {
			show_404($this->uri->uri_string(), '请检查您输入的词条编号是否正确');
		}

		// 设置分页
		$conditions = "mid IN (SELECT mid FROM `correlateweibo` WHERE entryid={$entryid})";
		if($type != 0){ // 查看关注用户的微博
			$fui = $this->Hit_UserModel->fui();
			$conditions .= " AND uid IN ({$fui})";
		}
		$total_rows = $this->Hit_WeibomsgModel->getRowsNum(array('conditions'=>$conditions), FALSE);
		$url_template = implode('/', array('detail','index',$entryid,$type,'{%s}',$rpagenum));
		$config = array(
					'url_template' => site_url($url_template),
					'total_rows' => $total_rows,
					'pagesize' => get_config_value('DETAIL_BLOG_PAGESIZE'),
					'cur_page' => $lpagenum
					);
		$this->load->library('Hit_Pagination',$config);
		$pagination = $this->hit_pagination->generatePagination();

		// 构造待传递参数
		$DETAIL_CORRELATE_RESOURCE_COUNT = get_config_value('DETAIL_CORRELATE_RESOURCE_COUNT');
		$DETAIL_CORRELATE_BLOGGERS_COUNT = get_config_value('DETAIL_CORRELATE_BLOGGERS_COUNT');
		$DETAIL_CORRELATE_ENTRY_COUNT = get_config_value('DETAIL_CORRELATE_ENTRY_COUNT');
		$blog_pagesize = get_config_value('DETAIL_BLOG_PAGESIZE');

		$entry = $this->Hit_EntryModel->select(array('conditions'=>"entryid={$entryid}",'limit'=>1), FALSE);
		if(count($entry) > 0){
			$entry = $entry[0];
		} else {
			show_404($this->uri->uri_string(), '请检查您输入的词条编号是否正确');
		}
		$bloggers = $this->hit_blogrecommender->getCorrelateBloggers($entryid, $DETAIL_CORRELATE_BLOGGERS_COUNT);
		$correlate_entries = $this->hit_entryrecommender->getCorrelateEntries($entryid, $DETAIL_CORRELATE_ENTRY_COUNT);
		$correlate_resources = $this->Hit_ResourceModel->selectCorrelateresource(array('entryid'=>$entryid,'limit'=>$DETAIL_CORRELATE_RESOURCE_COUNT));
		if($type != 0){
			$blogs = $this->hit_blogrecommender->getDetailPageCorrelateBlogs($entryid, ($lpagenum-1)*$blog_pagesize, $blog_pagesize, $fui);
		} else {
			$blogs = $this->hit_blogrecommender->getDetailPageCorrelateBlogs($entryid, ($lpagenum-1)*$blog_pagesize, $blog_pagesize);
		}
		$right_box = get_right_box($rpagenum);

		// 分享按钮内容处理
		$msg = $entry["name"] . ':' . mb_substr($entry["description"], 0, 90, 'utf-8') . '\n我正在使用微博词条，发现微博中的新知识，成为知识达人，你也快来试试吧！';
	    $share_script = "<script type='text/javascript' charset='utf-8'>
			var _w = 106 , _h = 58;
			var param = {
				url:location.href,
			    type:'6',
    			count:0, /**是否显示分享数，1显示(可选)*/
    			appkey:'244566215', /**您申请的应用appkey,显示分享来源(可选)*/
    			title:'" . $msg . "', /**此处的分享应与词条相关*/
    			pic:'', /**分享图片的路径(可选)*/
    			ralateUid:'', /**关联用户的UID，分享微博会@该用户(可选)*/
    			rnd:new Date().valueOf()
    		}
			var temp = [];
  			for( var p in param ){
  			    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
    		}
			document.write('<iframe allowTransparency=\"true\" frameborder=\"0\" scrolling=\"no\" src=\"http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '\" width=\"'+ _w+'\" height=\"'+_h+'\"></iframe>')
			</script>";
		
		$data = array(
					'entry'=>$entry, 
					'blogs'=>$blogs,
					'bloggers'=>$bloggers,
					'share_script'	=> $share_script,
					'correlate_entries'=>$correlate_entries,
					'correlate_resources'=>$correlate_resources,					
					'pagination' => $pagination,
					'right_box' => $right_box
				);

		$this->load->auto_view('detail', $data);
	}
}
