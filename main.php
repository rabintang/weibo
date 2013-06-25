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
	<div class="all">
  	<?php include 'head.php';?>
	<?php include 'includes/pagination.php';?>
	<div class="middle">
		<!-- bof 页面中部 -->
		<div class="main_wrap">
			<!-- bof 词条列表 -->	
			<div class="main"><?	
				define("lpagesize",6);
				define("rpagesize",15);
				define('need_more_kl',10);
				$pagebase = 'main.php?';
				$lpage = Tool::get("lpage");
				$rpage = Tool::get("rpage");
				$type = Tool::get("type");
				$lpage = Tool::convert($lpage,1);
				$rpage = Tool::convert($rpage,1);
				$param = 'lpage='.$lpage;
				$condition = '';
				if(!empty($type)) {
					$type = Tool::convert($type,1);
					$condition = "AND cgid=$type";
					$param .= '&&type='.$type;
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
				while($row = mysql_fetch_array($result)) {?>
				<!-- bof 词条 -->
			  	<div class="voc_main" id="voc1">
					<div class="content_a">
						<p><a href='detail.php?abbre=<? echo($row["abrid"]);?>'><? echo($row["kl"]);?></a>
						&nbsp;&nbsp;<? echo($row["bf"]);?></p>
					</div>
					<? Tool::echo_relateknowledge($row,4);?>
					<? Tool::echo_relatelink($row);?>
					<!-- bof 微博列表 -->
					<div class="main_weibo">
					  <div class="weibo_tittle">
					     <span >相关微博: </span>
					     <? Tool::echo_relatebloger($row,5);?>
					  </div>
					  <? Tool::echo_weibobrief($row);?>
					</div>
					<!-- eof 微博列表 -->
					<div class="voc_foot">
						<div class="voc_foot_time"><?=$row['pt']?></div>
						<div class="voc_foot_option">
                            <span class="tweet-viewpoint">
							   	<a class="tweet-praise" href="javascript:;" title="顶并转发" data-type="top">
								    <em class="icon-praise"></em>
								    <span class="tweet-viewpoint-count">(32)</span>
							   	</a>
							   	<a class="tweet-disdain" href="javascript:;" title="踩并转发" data-type="down">
								    <em class="icon-disdain"></em>
								    <span class="tweet-viewpoint-count">(23)</span>
							   	</a>
							</span>
                            <a class="retweet-trigger" href="javascript:;" title="转发这条词条">转发<span class="retweet-counter">(56)</span></a>
               				<a class="fav-trigger" data-favorited="false" title="收藏这条词条" href="javascript:;">收藏</a>
                            <a class="reply-trigger" title="评论这条词条" href="javascript:;">评论<span class="reply-counter">(33)</span></a>
						</div>
					</div>
					<!-- bof 微博评论转发 -->
					<div class="tweet-talk" style="display: none;">
						<div class="tweet-talk-arrow" style="left: 514px;">
							<em class="icon-arrow-up" style="left: 0px;"></em>
						</div>
						<div class="tweet-talk-hd">
							<h3>评论词条</h3><a class="icon-close close-trigger" href="javascript:;" title="关闭"></a>
						</div>
						<div class="tweet-publishBox">
							<div class="tweet-publishBox-hd">
								<div class="tweet-publishBox-textareaBox">
									<label class="tweet-publishBox-defaultTips js-default-tip" style="display: block;">点击添加评论</label>
									<textarea class="tweet-publishBox-textarea" style="height: 54px; overflow-y: hidden;"></textarea>
								</div>
							</div>
							<div class="tweet-publishBox-ft js-publishBoxFt">
								<div class="clearfix">
									<div class="tweet-publishBox-operate">
										<div class="tweet-publishBox-btn">
											<a class="submit-trigger disabled" href="javascript:;">评论</a>
										</div>
										<span class="tweet-publishBox-tip js-wordCounter">还可以输<span class="char-constantia">163</span>字</span>
										<div class="tweet-publishBox-insert">
											<div class="insert-list">
												<a class="insert-at at-trigger" title="@Ta的昵称或备注可以提到Ta" href="javascript:;"><em class="icon-at"></em></a>
												<a class="insert-face face-trigger" title="表情" href="javascript:;"><em class="icon-face"></em></a>
											</div>
										</div>
									</div>
									<span class="fl">
										<label class="label-tag">
											<input name="isRetweet" type="checkbox" class="js-Checkbox">同时转发到我的微博
										</label>
									</span>
								</div>
							</div>
						</div>
						<div class="tweet-talk-bd" style="display: none;">
							<div class="tweet-talk-content">
								<ul class="tweet-talk-list js-tweetTalkList clearfix towerTweet-talk-list towerList" data-tweet-id="-3937890993794894604" data-user-id="7782688865979458019"></ul>
								<div class="tweet-talk-ft">
									<div class="tweet-talk-page link-lb js-pages">
										<div class="pages-small" style="">
										</div>
									</div>
									<a href="" class="link-lb tweet-talk-link-all js-link-all fFS" data-method="readMore" target="_blank">查看全部&gt;&gt;</a>
								</div>
							</div>
						</div>
						<a class="tweet-talk-shrink close-trigger" href="javascript:;" style="display: none;">
							<em class="icon-shrink"></em>
						</a>
					</div>
					<!-- eof 微博评论转发 -->
				</div>
				<!-- eof 词条 --><?
			    }
			  	$query = "SELECT COUNT(abrid) AS num FROM `abbreviation` WHERE abrid in (SELECT abrid FROM `abbre_weibomsg`" 
								. " WHERE mid IN (SELECT mid FROM `weibomsg` WHERE uid IN ({$fui})))";
			  	if(isset($type) && $type != NULL)
			  		$query = $query." AND cgid=$type";
			  	$result = Conn::select($query);
			  	$total_rows = 0;
			  	if(mysql_num_rows($result) > 0){
			  		$row = mysql_fetch_row($result);
			  		$total_rows = $row[0];
			  	}
			  	$page = new Page((int)$total_rows,'main.php',$lpage,lpagesize);
			  	$param_str = "rpage=$rpage";
			  	if(isset($type) && $type != NULL){
			  		$param_str = $param_str."&&type=$type";
			  	}
			  	$page->echo_navigation("lpage",$param_str);?>
			</div>
			<!-- eof 词条列表 -->
			
			<?php include('box_right.php');?>
		</div>
	</div>
	<span style="clear:both;"></span>
	<!-- eof 页面中部 -->
	<?php include 'foot.php';?>
</div>
</body>
</html>
