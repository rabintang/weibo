<?
class Page{
	private $adjacents = 3; 	// How many adjacent pages should be shown on each side?
	private $total_pages;
	private $total_rows;
	private $targetpage;	//your file name  (the name of this file)
	private $cur_page; //the index of current page.
	private $start; //the first item to display on this page.
	private $pagesize; //how many items to show per page.

	private function init($total_rows,$targetpage,$cur_page,$pagesize){
		$this->targetpage = $targetpage;
		if($pagesize && $pagesize > 0)
			$this->pagesize = $pagesize;
		else
			$this->pagesize = 10;
		if($cur_page && $cur_page > 0)
			$this->cur_page = $cur_page;
		else
			$this->cur_page = 1;
		$this->total_rows = $total_rows;
		$this->total_pages = (int)($this->total_rows / $this->pagesize);
		if($this->total_rows % $this->pagesize != 0){
			$this->total_pages++;
		}
		$this->start = ($this->cur_page-1)*$this->pagesize;
	}

	public function __construct($condition,$targetpage,$cur_page,$pagesize){
		if(gettype($condition) == 'string'){
			$query = "SELECT COUNT(*) as num FROM $condition";
			$result = Conn::select($query);
			$row = mysql_fetch_array($result);
			$total_rows = $row['num'];
		} else {
			$total_rows = $condition;
		}
		$this->init($total_rows,$targetpage,$cur_page,$pagesize);
	}

	public function echo_navigation($param_name,$param_str){
		/* Setup page vars for display. */
		$prev = 1;
		$next = $this->total_pages;
		$lastpage = $this->total_pages;
		if($this->cur_page > 1)
			$prev = $this->cur_page - 1;				//previous page is page - 1
		if($this->cur_page < $this->total_pages)
			$next = $this->cur_page + 1;				//next page is page + 1
		$lpm1 = $lastpage - 1;						//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		$url = $this->targetpage."?";
		if($param_str && $param_str != ""){
			$url = $url.$param_str."&&$param_name=";
		} else {
			$url = $url."$param_name=";
		}
		if($lastpage > 1)
		{	
			$pagination .= "<div class='pagination'>";
			//previous button
			if ($this->cur_page > 1) 
				$pagination.= "<a href='$url$prev'>&lt;&lt; 上一页</a>";
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
						$pagination.= "<a href='$url$counter'>$counter</a>";
				}
			}
			elseif($lastpage > 5 + ($this->adjacents * 2))	//enough pages to hide some
			{
			    $url1 = $url.'1';
			    $url2 = $url.'2';
				//close to beginning; only hide later pages
				if($this->cur_page < 1 + ($this->adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
					{
						if ($counter == $this->cur_page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$url$counter\">$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$url$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$url$lastpage\">$lastpage</a>";
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
							$pagination.= "<a href=\"$url$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$url$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$url$lastpage\">$lastpage</a>";		
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
							$pagination.= "<a href=\"$url$counter\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($this->cur_page < $counter - 1) 
				$pagination.= "<a href=\"$url$next\">下一页 &gt;&gt;</a>";
			else
				$pagination.= "<span class=\"disabled\">下一页 &gt;&gt;</span>";
			$pagination.= "</div>\n";		
		}
		echo($pagination);
	}
}
?>