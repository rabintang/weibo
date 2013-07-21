<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>您的词条-知识推荐</title>
	<base href="<?=get_assets_base_url();?>" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link href="css/base.css" type="text/css" rel="stylesheet">
	<link href="css/main.css" type="text/css" rel="stylesheet">
	<link href="css/pagination.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<div class="all">
  	<?=$head;?>
	<div class="middle">
		<!-- bof 页面中部 -->
		<div class="main_wrap">
			<!-- bof 词条列表 -->	
			<div class="main"><?php
			foreach($items as $item) {?>
				<!-- bof 词条 -->
			  	<div class="voc_main" id="voc1">
					<div class="content_a">
						<p><a href='<?=site_url("detail/index/{$item['abbre']['abrid']}");?>'><?=$item['abbre']['kl'];?></a>
						&nbsp;&nbsp;<?=$item['abbre']['bf'];?></p>
					</div><?php
					if(isset($item['relate_abbres'])) {
						echo get_relate_abbres($item['relate_abbres']);
					}?>
					<?=get_wk_bk($item['abbre']['wk'], $item['abbre']['bk']);?>
					<!-- bof 微博列表 -->
					<div class="main_weibo">
					  	<div class="weibo_tittle">
						    <span >相关微博: </span><?php
						    if(isset($item['bloggers'])){
						    	echo get_relate_blogger($item['bloggers']);
							}?>
					  	</div><?php 
					  	if(isset($item['wb_brif']) && sizeof($item['wb_brif']) > 0) {?>
					  		<div class="weibo_tittle_sep">
					  			<div class="weibo_tittle_sep_line"></div>
					  		</div><?php
					  		$first_flag = TRUE;
					  		foreach($item['wb_brif'] as $wb_brif){
					  			if( ! $first_flag) {
					  				echo '<div class="weibo_sep"><div class="weibo_sep_line"></div></div>';
					  			}
					  			$first_flag = FALSE;
					  			echo $wb_brif;
					  		}
						}?>
					</div>
					<!-- eof 微博列表 -->
					<div class="voc_foot">
						<div class="voc_foot_time"><?=$item['abbre']['pt'];?></div>
						<div class="voc_foot_option">
                            <span class="tweet-viewpoint">
							   	<a class="tweet-praise" href="javascript:;" title="顶并转发" data-type="top">
								    <em class="icon-praise"></em>
								    <span class="tweet-viewpoint-count"></span>
							   	</a>
							   	<a class="tweet-disdain" href="javascript:;" title="踩并转发" data-type="down">
								    <em class="icon-disdain"></em>
								    <span class="tweet-viewpoint-count"></span>
							   	</a>
							</span>
                            <a class="retweet-trigger" href="javascript:;" title="转发这条词条">转发<span class="retweet-counter"></span></a>
               				<a class="fav-trigger" data-favorited="false" title="收藏这条词条" href="javascript:;">收藏</a>
                            <a class="reply-trigger" title="评论这条词条" href="javascript:;">评论<span class="reply-counter"></span></a>
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
				<!-- eof 词条 --><?php 
			} ?>
			<?=$pagination;?>
			</div>
			<!-- eof 词条列表 -->
			
			<?=$box_right;?>
		</div>
	</div>
	<span style="clear:both;"></span>
	<!-- eof 页面中部 -->
	<?=$foot;?>
</div>
</body>
</html>