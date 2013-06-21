<!DOCTYPE html>
<html>
<head>
  <title>自然语言处理-知识推荐</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/detail.css" type="text/css" rel="stylesheet">
  <link href="css/pagination.css" type="text/css" rel="stylesheet">
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<?php include_once 'includes/conn.php';?>
	<?php include_once 'includes/tool.php';?>
	<?php include_once 'includes/pagination.php';?>
  	<?php include 'head.php';?>
  
	<!-- 页面中部
    ================================================== -->
    <?
    	define("pagesize",10);
    	define("resource_size",4);
    	$cur_page = Tool::get("page");
    	$constrain = Tool::get("constrain");
    	$constrain = Tool::convert($constrain,0);
    	$cur_page = Tool::convert($cur_page,1);
    	$abrid = Tool::get("abbre");
    	$sql = "SELECT * FROM `abbreviation` WHERE abrid=$abrid";
    	$result = Conn::select($sql);
    	if(mysql_num_rows($result) > 0)
    		$item = mysql_fetch_array($result);
    	else
    		echo "<script>window.location ='404.php';</script>";
    ?>
	<div class="main_wrap">	
		<!-- 词条及相关微博
        ================================================== -->
		<div class="main">
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
		      <a href="main.php" ><img src="img/title_share_button.gif"  class="raw_image"></a>
		    </div>
	      </div>
		  <div class="explain">
		    <span><?echo($item["bf"]);?></span>
		  </div>
		  <!--<div class="relate_resource">
			<span class="relate_resource_title">相关资源：</span><span class="relate_resource_content"><?Tool::echo_relateresource($item['abrid'],resource_size);?></span>
		  </div>-->
		  <? Tool::echo_relateresource($item['abrid'],resource_size);?>
		  <? Tool::echo_relateknowledge($item,5);?>
		  <? Tool::echo_relatelink($item);?>
		  <div class="relate_blogger">
		    <span >相关博主: </span>
		    <? Tool::echo_relatebloger($item,5);?>
		  </div>
		  
		  <!-- 微博列表 -->
		  <div class="weibo_list">
		    <div class="relate_weibo">
			  <span >相关微博: </span>
			  <a href="detail.php?abbre=<?echo($abrid);?>&&constrain=1">只看关注用户</a>
			  <span class="split_font"> | </span>
			  <a href="detail.php?abbre=<?echo($abrid);?>">全部用户</a>
			</div>
			<div class="weibo_title_split">
			  <div class="weibo_title_split_line">
			  </div>
			</div>
			<?
				if($constrain == 1) {
				    $fui = Tool::get_fui($_SESSION['uid']);
					$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid) AND uid IN ";
					$sql = $sql."({$fui}) ORDER BY pt DESC LIMIT ".($cur_page-1)*pagesize.",".pagesize;
				} else {
					$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT t.mid FROM (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid LIMIT ";
					$sql = $sql.($cur_page-1)*pagesize.",".pagesize.") AS t) ORDER BY pt DESC";
				}
				$result = Conn::select($sql);
				while($row = mysql_fetch_array($result)){
			?>
			<!-- 微博 -->
			<div class="weibo">
			  <div class="blogger_img">
			    <img src="<?echo($row['iu']);?>"  class="raw_image">
			  </div>
			  <div class="weibo_content">
			    <span><a href="http://www.weibo.com/<?echo($row['uid']);?>" target="_blank"><font color="#0082CB"><?echo($row['sn']);?></font></a>：
			    	<? Tool::echo_wbmsg($row,$item['kl']);?></span>
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
			  <div class="weibo_split">
			    <div class="weibo_split_line">
			    </div>
			  </div>
			</div>
			<!-- end 微博 -->
			<?
			    }
			?>

		  <!-- 微博分页 -->
		  <?
		  	if($constrain == 1){
		  		$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid) AND uid IN ({$fui})";
		  	} else {
		  		$sql = "SELECT * FROM `weibomsg` WHERE mid IN (SELECT mid FROM `abbre_weibomsg` WHERE abrid=$abrid)";
		  	}
			$result = Conn::select($sql);
			$condition = mysql_num_rows($result);
			
		  	$page = new Page($condition,"detail.php",$cur_page,pagesize);
		  	$param_str = "abbre=$abrid";
		  	if($constrain == 1) {
		  		$param_str = $param_str."&&constrain=1";
		  	}
		  	$page->echo_navigation('page',$param_str);
		  ?>
		  <!-- end 微博分页 -->
		  </div>
		  <!-- end 微博列表 -->
		</div>
		<!-- end 词条及相关微博 -->
	</div>
	<!-- end 页面中部 -->
	
	<?php include 'foot.php';?>	
</body>
</html>