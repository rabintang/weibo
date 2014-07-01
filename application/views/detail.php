<!DOCTYPE html>
<html>
<head>
  	<title><?=$entry["name"];?>-知识推荐</title>
	<base href="<?=get_assets_base_url();?>" />
  	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  	<link href="css/base.css" type="text/css" rel="stylesheet">
  	<link href="css/pagination.css" type="text/css" rel="stylesheet">
  	<link href="css/main.css" type="text/css" rel="stylesheet">
  	<link href="css/detail.css" type="text/css" rel="stylesheet">
  	<script type="text/javascript" src="js/global.js"></script>
  	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  	<script type="text/javascript" src="js/detail.js"></script>
</head>
<body>
	<div class="all">
	<?=$head;?>  
	<!-- bof 页面中部 --> 
	<form name="recordActionFrm" id="recordActionFrm" method="post" action='detail'>
		<input id="sourceField" type="hidden" name="source" value="">
	</form>
	<div class="middle">
		<div class="main_wrap">	
			<!-- bof 词条及相关微博 -->
			<div class="main">
				<div class="detail_head">
				  	<div class="title">
					    <div class="title_content">
					      	<span class="span1"><?=$entry["name"];?></span>
					    </div>
					    <div class="title_more">
					      	<span class="span2">收入时间 </span> <span class="span3"><?=$entry["publishtime"];?></span> 
					      	<span class="split_font"> | </span> <span class="span2">查看(</span> 
					      	<span class="span3"><?=$entry["viewcount"];?></span> <span class="span2">)</span> 
					      	<span class="split_font"> | </span> <span class="span2">分享(</span> 
					      	<span class="span3"><?=$entry["sharecount"];?></span> <span class="span2">)</span>
					    </div>
					    <div class="title_share_button">
					    <?=$share_script;?>
					    </div>
			      	</div>
				  	<div class="explain">
				    	<span><?=$entry["description"];?></span>
				  	</div><?php
				  	if(isset($correlate_resources) && count($correlate_resources) > 0){?>
				  		<div class="relate_resource">
				  			<span class="relate_resource_title">相关资源：</span>
				  			<span class="relate_resource_content"><?php
				  			$is_first = TRUE;
				  			foreach($correlate_resources as $resource){
				  				if( ! $is_first ){
				  					echo '<span class="split_font"> | </span>';
				  				}
				  				echo "<a href={$resource['url']} target='_blank'>{$resource['title']}</a>";
				  				$is_first = FALSE;
				  			}
				  			echo '</span></div>';
				  	}
				  	if(isset($correlate_entries)){
				  		echo get_correlate_entries($correlate_entries, 'detail');
				  	}?>
				  	<?=get_wiki_and_baike($entry["wiki"],$entry["baike"]);?>
				  	<div class="relate_blogger">
				    	<span >相关博主: </span>
				    	<?=get_correlate_bloggers($bloggers);?>
				  	</div>		  
				  	<!-- bof 微博列表 -->
				    <div class="relate_weibo">
				    	<span id="info"></span>
				    	<ul id="weibofilter">
				    		<li class><a href='<?=site_url("detail/index/{$entry['entryid']}/0");?>'>查看全部用户</a></li>
						  	<li class><a href='<?=site_url("detail/index/{$entry['entryid']}/1");?>'>只看关注用户</a></li>
						</ul>
					</div>
				</div>
			  	<div class="weibo_list">
				<!-- bof 微博 --><?php
				foreach($blogs as $blog){?>
					<div class="weibo_detail">
					  	<div class="blogger_img">
					    		<a href="http://www.weibo.com/<?=$blog['uid'];?>" target="_blank">
								<img src="<?=$blog['iu'];?>" class="raw_image"></a>
					  	</div>
					  	<div class="weibo_content">
					  		<span class="user_name">
					    		<a href="http://www.weibo.com/<?=$blog['uid'];?>" target="_blank"><?=$blog['un'];?></a>：
					    	</span>
					    	<?=$blog['mc'];?>&nbsp;详见：<a href='<?=$blog['page'];?>' target='_blank'>
					    		<font color='#0082D1'><?=$blog['page'];?></font></a>
					  	</div>
					  	<div class="weibo_more">
						    <div class="weibo_more_left">
							  	<span class="span1"><?=$blog['pt'];?></span>
							  	<span class="span2">来自</span> <span class="span1"><?=$blog['srn'];?></span>
							</div>
							<div class="weibo_more_right">
							  	<a href="#">转发(<?=$blog['rc'];?>)</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">收藏</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">评论(<?=$blog['cc'];?>)</a>
							</div>
					  	</div>
					</div><?
				}?>
				<!-- eof 微博 -->
			  	<!-- bof 微博分页 -->
			  	<?=$pagination;?>
			  	<!-- eof 微博分页 -->
			  	</div>
			  	<!-- eof 微博列表 -->
			</div>
			<!-- eof 词条及相关微博 -->
			<?=$right_box;?>
		</div>
	</div>
	<!-- eof 页面中部 -->	
	<?=$foot;?>
</div>
</body>
</html>
