<!DOCTYPE html>
<html>
<head>
  <title>自然语言处理搜索结果-知识推荐</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/main.css" type="text/css" rel="stylesheet">
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<?php include_once 'includes/conn.php';?>
	<?php include 'includes/tool.php';?>
	<?php include_once 'includes/pagination.php';?>
  	<?php include 'head.php';?>	
  
	<!-- 页面中部
    ================================================== -->
	<div class="main_wrap">
		<?
			$kl = Tool::get("word");
			$sql = "SELECT COUNT(*) AS num FROM `abbreviation` WHERE kl='$kl'";
			$result = Conn::select($sql);
			$row = mysql_fetch_array($result);
			$total_results = $row['num'];
			if($total_results == 0){
				echo "<script>window.location ='nofound.php?word=$kl';</script>";
			}
		?>
		<!-- 词条列表
        ================================================== -->		
		<div class="main">
		  <div class="search_title">
		    <span class="span1">搜索</span>
		    <span class="span2"><?echo($kl);?></span>
		    <span class="span3">的结果</span>
		    <span class="span4">(共<?echo($total_results);?>条)</span>
		  </div>
		  <?
		  	define("lpagesize",3);
			define("rpagesize",10);
			$lpage = Tool::get("lpage");
			$rpage = Tool::get("rpage");
			$lpage = Tool::convert($lpage,1);
			$rpage = Tool::convert($rpage,1);
			$sql = "SELECT * FROM `abbreviation` WHERE kl='$kl' ORDER BY abrid DESC LIMIT ".($lpage-1)*lpagesize.",".lpagesize;
			$result = Conn::select($sql);
			while($row = mysql_fetch_array($result)) {
		  ?>
		  <!-- 词条
          ================================================== -->
		  <div class="voc_main" id="voc1">
			<div class="content_a">
				<p><a href='detail.php?abbre=<? echo($row["abrid"]);?>'><span><? echo($row["kl"]);?></span></a>
				&nbsp;&nbsp;<? echo($row["bf"]);?></p>
			</div>
			<? Tool::echo_relateknowledge($row,4);?>
			<? Tool::echo_relatelink($row);?>
			<!-- 微博列表 -->
			<div class="main_weibo">
			  <div class="weibo_tittle">
			     <span >相关微博: </span>
			     <? Tool::echo_relatebloger($row,5);?>
			  </div>
			  <? Tool::echo_weibobrief($row);?>
			</div>
			  <!-- end 微博列表 -->
			</div>
			<!-- end 词条 -->
		  <?
		    }   
		  ?>
		  
		  <!-- 分页 -->
		  <?
		  	$condition = "`abbreviation` WHERE kl='$kl'";
		  	$page = new Page($condition,'search.php',$lpage,lpagesize);
		  	$param_str = "rpage=$rpage";
		  	$page->echo_navigation("lpage",$param_str);
		  ?>
		  <!-- end 分页 -->
		  
		</div>
		<!-- end 词条列表 -->
		
		<!-- 导航栏
        ================================================== -->
		<div class="catalog_wrap">
		  <div class="catalog">
		    <div class="cat_tittle">
			  <span>目录</span>
			</div>
			<div class="cat_line_wrap">
			   <div class="cat_line">
			   </div>
			</div>
			<? Tool::echo_rnavig($rpage,rpagesize,"kl='$kl'");?>
			<div class="voc_navi">
			  <? $url = "search.php?word=$kl&&";?>
			  <a href="<?Tool::echo_rnavigurl($rpage,1,$lpage,NULL,$url);?>">
			  <div class="voc_navi_pre">
			    <span>∧</span>
			  </div>
			  </a>
			   <a href="<?Tool::echo_rnavigurl($rpage,2,$lpage,NULL,$url);?>">
			  <div class="voc_navi_next">
			    <span>∨</span>
			  </div>
			  </a>
			</div>
		  </div>
		</div>
		<!-- end 导航栏 -->
	
	</div>
	<!-- end 页面中部 -->
	
	<?php include 'foot.php';?>
</body>
</html>