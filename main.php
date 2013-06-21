<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>您的词条-知识推荐</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/main.css" type="text/css" rel="stylesheet">
  <link href="css/pagination.css" type="text/css" rel="stylesheet">
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
  <?php include_once 'head.php';?>
	<?php include_once 'includes/pagination.php';?>
	<?php include_once 'includes/tool.php';?>
	<!-- 页面中部
    ================================================== -->
	<div class="main_wrap">	
		<!-- 词条列表
        ================================================== -->
		<div class="main">		    
			<?	
				define("lpagesize",10);
				define("rpagesize",15);
				define('need_more_kl',10);
				$lpage = Tool::get("lpage");
				$rpage = Tool::get("rpage");
				$type = Tool::get("type");
				$lpage = Tool::convert($lpage,1);
				$rpage = Tool::convert($rpage,1);
				$condition = '';
				if(!empty($type)) {
					$type = Tool::convert($type,1);
					$condition = "AND cgid=$type";
				}
				
				$sql = "SELECT fui FROM `userlist` WHERE uid='{$_SESSION['uid']}'";
				$result = Conn::select($sql);
				$fui = Tool::get_fui($_SESSION['uid']);
				$sql = "SELECT * FROM `abbreviation` WHERE abrid in (SELECT abrid FROM `abbre_weibomsg`" 
							. " WHERE mid IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui})))"
							. $condition ." ORDER BY abrid DESC LIMIT " . ($lpage-1)*lpagesize.",".lpagesize;
				$result = Conn::select($sql);
				if($lpage == 1 && mysql_num_rows($result) < 10){ // The knowledge to show is to less
					$num = need_more_kl - mysql_num_rows($result);
					$sql = "SELECT * FROM `abbreviation` WHERE abrid NOT IN (SELECT abrid FROM `abbre_weibomsg` 
						WHERE mid IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui})) ORDER BY abrid DEST LIMIT {$num}";
					$result_more = Conn::select($sql);
				}
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
		  <?
		  	$query = "SELECT COUNT(abrid) AS num FROM `abbreviation` WHERE abrid in (SELECT abrid FROM `abbre_weibomsg`" 
							. " WHERE mid IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui})))";
		  	if(isset($type) && $type != NULL)
		  		$query = $query." AND cgid=$type";
		  	$result = Conn::select($query);
		  	$total_rows = 0;
		  	if(mysql_num_rows($result) > 0){
		  		$row = mysql_fetch_array($result);
		  		$total_rows = $row['num'];
		  	}
		  	$page = new Page((int)$total_rows,'main.php',$lpage,lpagesize);
		  	$param_str = "rpage=$rpage";
		  	if(isset($type) && $type != NULL){
		  		$param_str = $param_str."&&type=$type";
		  	}
		  	$page->echo_navigation("lpage",$param_str);
		  ?>
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
			<? Tool::echo_rnavig($rpage,rpagesize,NULL);?>
			<div class="voc_navi">
			  <a href="<?Tool::echo_rnavigurl($rpage,1,$lpage,$type,'main.php?');?>">
			  <div class="voc_navi_pre">
			    <span>∧</span>
			  </div>
			  </a>
			   <a href="<?Tool::echo_rnavigurl($rpage,2,$lpage,$type,'main.php?');?>">
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
