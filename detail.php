<!DOCTYPE html>
<html>
<head>
  <title>自然语言处理-知识推荐</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/pagination.css" type="text/css" rel="stylesheet">
  <link href="css/main.css" type="text/css" rel="stylesheet">
  <link href="css/detail.css" type="text/css" rel="stylesheet">
  <script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="js/detail.js"></script>
</head>
<body>
	<div class="all">
	<?php include_once 'includes/conn.php';?>
	<?php include_once 'includes/tool.php';?>
	<?php include_once 'includes/pagination.php';?>
  	<?php include 'head.php';?>
  
	<!-- bof 页面中部 --> <?
	define("lpagesize",10);
	define("rpagesize",13);
	define("resource_size",4);
	$pagebase = 'detail.php?';
	$lpage = Tool::get("lpage");
	$rpage = Tool::get("rpage");
	$lpage = Tool::convert($lpage,1);
	$rpage = Tool::convert($rpage,1);
	$type = Null;
	$constrain = Tool::get("constrain");
	$constrain = Tool::convert($constrain,0);
	$abrid = Tool::get("abbre");
	$param = 'lpage='.$lpage.'&&abbre='.$abrid;
	$sql = "SELECT * FROM `abbreviation` WHERE abrid=$abrid";
	$result = Conn::select($sql);
	if(mysql_num_rows($result) > 0)
		$item = mysql_fetch_array($result);
	else
		echo "<script>window.location ='404.php';</script>";?>
	<div class="middle">
		<div class="main_wrap">	
			<!-- bof 词条及相关微博 -->
			<div class="main">
				<div class="detail_head">
				  	<div class="title">
					    <div class="title_content">
					      	<span class="span1"><? echo($item["kl"]);?></span>
					    </div>
					    <div class="title_more">
					      	<span class="span2">收入时间 </span> <span class="span3"><? echo($item["pt"]);?></span> 
					      	<span class="split_font"> | </span> <span class="span2">查看(</span> 
					      	<span class="span3"><? echo($item["vt"]);?></span> <span class="span2">)</span> 
					      	<span class="split_font"> | </span> <span class="span2">分享(</span> 
					      	<span class="span3"><? echo($item["st"]);?></span> <span class="span2">)</span>
					    </div>
					    <div class="title_share_button">
					      	<a href="main.php" ><img src="img/title_share_button.gif"  class="share_image"></a>
					    </div>
			      	</div>
				  	<div class="explain">
				    	<span><?echo($item["bf"]);?></span>
				  	</div>
				  	<? Tool::echo_relateresource($item['abrid'],resource_size);?>
				  	<? Tool::echo_relateknowledge($item,5);?>
				  	<? Tool::echo_relatelink($item);?>
				  	<div class="relate_blogger">
				    	<span >相关博主: </span>
				    	<? Tool::echo_relatebloger($item,5);?>
				  	</div>		  
				  	<!-- bof 微博列表 -->
				    <div class="relate_weibo">
				    	<span id="info"></span>
				    	<ul id="weibofilter">
				    		<li class><a href="detail.php?abbre=<?=$abrid;?>&&rpage=<?=$rpage;?>">查看全部用户</a></li>
						  	<li class><a href="detail.php?abbre=<?=$abrid;?>&&constrain=1&&rpage=<?=$rpage;?>">只看关注用户</a></li>
						</ul>
					</div>
				</div>
			  	<div class="weibo_list">
				<!-- bof 微博 --><?
				if($constrain == 1) {
				    $fui = Tool::get_fui($_SESSION['uid']);
					$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid) AND uid IN ";
					$sql = $sql."({$fui}) ORDER BY pt DESC LIMIT ".($lpage-1)*lpagesize.",".lpagesize;
				} else {
					$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT t.mid FROM (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid LIMIT ";
					$sql = $sql.($lpage-1)*lpagesize.",".lpagesize.") AS t) ORDER BY pt DESC";
				}
				$result = Conn::select($sql);
				while($row = mysql_fetch_array($result)){?>
					<div class="weibo_detail">
					  	<div class="blogger_img">
					    	<img src="<?echo($row['iu']);?>"  class="raw_image">
					  	</div>
					  	<div class="weibo_content">
					  		<span class="user_name">
					    		<a href="http://www.weibo.com/<?echo($row['uid']);?>" target="_blank"><?echo($row['sn']);?></a>：
					    	</span>
					    	<? Tool::echo_wbmsg($row,$item['kl']);?>
					  	</div>
					  	<div class="weibo_more">
						    <div class="weibo_more_left">
							  	<span class="span1"><?echo($row['pt']);?></span> <span class="span2">来自</span> <span class="span1"><?echo($row['srn']);?></span>
							</div>
							<div class="weibo_more_right">
							  	<a href="#">转发(<?echo($row['rc']);?>)</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">收藏</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">评论(<?echo($row['cc']);?>)</a>
							</div>
					  	</div>
					</div><?
				}?>
				<!-- eof 微博 -->
			  	<!-- bof 微博分页 --> <?
			  	if($constrain == 1){
			  		$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid) AND uid IN ({$fui})";
			  	} else {
			  		$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid)";
			  	}
				$result = Conn::select($sql);
				$condition = mysql_num_rows($result);
				
			  	$page = new Page($condition,"detail.php",$lpage,lpagesize);
			  	$param_str = "abbre=$abrid&&rpage=$rpage";
			  	if($constrain == 1) {
			  		$param_str = $param_str."&&constrain=1";
			  	}
			  	$page->echo_navigation('lpage',$param_str);?>
			  	<!-- eof 微博分页 -->
			  	</div>
			  	<!-- eof 微博列表 -->
			</div>
			<!-- eof 词条及相关微博 -->
			<?php include('box_right.php');?>
		</div>
	</div>
	<!-- eof 页面中部 -->	
	<?php include 'foot.php';?>
</div>
</body>
</html>
