<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 自定义的分页类
 */

class Hit_Pagination{
	const PAGE_FLAG = '{%s}'; // 用于替换页码的标记

	private $adjacents = 3; // How many adjacent pages should be shown on each side?
	private $total_pages;
	private $total_rows;
	private $url_template;	//URL模板,页码部分用 {%s} 代替
	private $cur_page; 		//the index of current page.
	private $pagesize; 		//how many items to show per page.

	/**
	 * 分页类构造函数
	 * @param array $config 配置信息
	 *                      url_template url模板,页码部分用 {%s} 代替
	 *                      total_rows	总记录数
	 *                      pagesize	每页记录数
	 *                      cur_page 	当前页页码
	 */
	function __construct($params = array())
	{
		if(isset($params['url_template']) && ! empty($params['url_template'])){
			$this->url_template = $params['url_template'];
		}
		if(isset($params['pagesize']) && $params['pagesize'] > 0){
			$this->pagesize = $params['pagesize'];
		} else{
			$this->pagesize = 10;
		}
		if(isset($params['cur_page']) && $params['cur_page'] > 0){
			$this->cur_page = $params['cur_page'];
		} else {
			$this->cur_page = 1;
		}
		if(isset($params['total_rows']) && $params['total_rows'] > 0){
			$this->total_rows = $params['total_rows'];
		} else {
			$this->total_rows = 0;
		}
		$this->total_pages = (int)($this->total_rows / $this->pagesize);
		if($this->total_rows % $this->pagesize != 0){
			$this->total_pages++;
		}
	}

	public function create_links()
	{
		/* Setup page vars for display. */
		$prev = 1;
		$next = $this->total_pages;
		$lastpage = $this->total_pages;
		if($this->cur_page > 1)
			$prev = $this->cur_page - 1;				//previous page is page - 1
		if($this->cur_page < $this->total_pages)
			$next = $this->cur_page + 1;				//next page is page + 1
		$lpm1 = $lastpage - 1;							//last page minus 1
		
		/* 
		 * Now we apply our rules and draw the pagination object. 
		 * We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		$bpos = strpos($this->url_template, Hit_Pagination::PAGE_FLAG);
		if( ! $bpos) {
			$bpos = strlen($this->url_template);
		}
		$url_pre = substr($this->url_template, 0, $bpos);
		$bpos = $bpos+strlen(Hit_Pagination::PAGE_FLAG);
		$url_next = substr($this->url_template, $bpos);
		if($lastpage > 1) {	
			$pagination .= "<div class='pagination'>";
			//previous button
			if ($this->cur_page > 1) 
				$pagination.= "<a href='$url_pre$prev$url_next'>&lt;&lt; 上一页</a>";
			else
				$pagination.= "<span class=\"disabled\">&lt;&lt; 上一页</span>";	
			
			//pages	
			if ($lastpage < 7 + ($this->adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $this->cur_page)
						$pagination.= "<span class='current'>$counter</span>";
					else
						$pagination.= "<a href='$url_pre$counter$url_next'>$counter</a>";
				}
			}
			elseif($lastpage > 5 + ($this->adjacents * 2))	//enough pages to hide some
			{
			    $url1 = $url_pre.'1'.$url_next;
			    $url2 = $url_pre.'2'.$url_next;
				//close to beginning; only hide later pages
				if($this->cur_page < 1 + ($this->adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
					{
						if ($counter == $this->cur_page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$url_pre$counter$url_next\">$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$url_pre$lpm1$url_next\">$lpm1</a>";
					$pagination.= "<a href=\"$url_pre$lastpage$url_next\">$lastpage</a>";
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($this->adjacents * 2) > $this->cur_page && $this->cur_page > ($this->adjacents * 2))
				{
					$pagination.= "<a href=\"$url1\">1</a>";
					$pagination.= "<a href=\"$url2\">2</a>";
					$pagination.= "...";
					for ($counter = $this->cur_page - $this->adjacents; $counter <= $this->cur_page + $this->adjacents; $counter++)
					{
						if ($counter == $this->cur_page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$url_pre$counter$url_next\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$url_pre$lpm1$url_next\">$lpm1</a>";
					$pagination.= "<a href=\"$url_pre$lastpage$url_next\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$url1\">1</a>";
					$pagination.= "<a href=\"$url2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $this->cur_page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$url_pre$counter$url_next\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($this->cur_page < $counter - 1) 
				$pagination.= "<a href=\"$url_pre$next$url_next\">下一页 &gt;&gt;</a>";
			else
				$pagination.= "<span class=\"disabled\">下一页 &gt;&gt;</span>";
			$pagination.= "</div>\n";		
		}
		return $pagination;
	}
}
?>