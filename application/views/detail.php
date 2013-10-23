<!DOCTYPE html>
<html>
<head>
  	<title><?=$abbre["kl"];?>-知识推荐</title>
	<base href="<?=get_assets_base_url();?>" />
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
	<?=$head;?>  
	<!-- bof 页面中部 --> 
	<div class="middle">
		<div class="main_wrap">	
			<!-- bof 词条及相关微博 -->
			<div class="main">
				<div class="detail_head">
				  	<div class="title">
					    <div class="title_content">
					      	<span class="span1"><?=$abbre["kl"];?></span>
					    </div>
					    <div class="title_more">
					      	<span class="span2">收入时间 </span> <span class="span3"><?=$abbre["pt"];?></span> 
					      	<span class="split_font"> | </span> <span class="span2">查看(</span> 
					      	<span class="span3"><?=$abbre["vt"];?></span> <span class="span2">)</span> 
					      	<span class="split_font"> | </span> <span class="span2">分享(</span> 
					      	<span class="span3"><?=$abbre["st"];?></span> <span class="span2">)</span>
					    </div>
					    <div class="title_share_button">
					      	<script type="text/javascript" charset="utf-8">
						var _w = 106 , _h = 58;
						   var param = {
							url:location.href,
						    type:'6',
			    			    count:'', /**是否显示分享数，1显示(可选)*/
			    			    appkey:'244566215', /**您申请的应用appkey,显示分享来源(可选)*/
			    			    title:'我正在使用微博词条，发现微博中的新知识，成为知识达人，你也快来试试吧！', /**此处的分享应与词条相关*/
			    			    pic:'', /**分享图片的路径(可选)*/
			    			    ralateUid:'', /**关联用户的UID，分享微博会@该用户(可选)*/
			    			    rnd:new Date().valueOf()
																								    			  }
						  var temp = [];
			  			  for( var p in param ){
			  			    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
			    			  }
						  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
			  			</script>
					    </div>
			      	</div>
				  	<div class="explain">
				    	<span><?=$abbre["bf"];?></span>
				  	</div><?php
				  	if(isset($relate_resources) && count($relate_resources) > 0){?>
				  		<div class="relate_resource">
				  			<span class="relate_resource_title">相关资源：</span>
				  			<span class="relate_resource_content"><?php
				  			$first_flag = TRUE;
				  			foreach($relate_resources as $resource){
				  				if( ! $first_flag){
				  					echo '<span class="split_font"> | </span>';
				  				}
				  				echo "<a href={$resource['url']} target='_blank'>{$resource['tl']}</a>";
				  				$first_flag = FALSE;
				  			}
				  			echo '</span></div>';
				  	}
				  	if(isset($relate_abbres)){
				  		echo get_relate_abbres($relate_abbres);
				  	}?>
				  	<?=get_wk_bk($abbre["wk"],$abbre["bk"]);?>
				  	<div class="relate_blogger">
				    	<span >相关博主: </span>
				    	<?=get_relate_blogger($bloggers);?>
				  	</div>		  
				  	<!-- bof 微博列表 -->
				    <div class="relate_weibo">
				    	<span id="info"></span>
				    	<ul id="weibofilter">
				    		<li class><a href='<?=site_url("detail/index/{$abbre['abrid']}/0");?>'>查看全部用户</a></li>
						  	<li class><a href='<?=site_url("detail/index/{$abbre['abrid']}/1");?>'>只看关注用户</a></li>
						</ul>
					</div>
				</div>
			  	<div class="weibo_list">
				<!-- bof 微博 --><?php
				foreach($statuses as $status){?>
					<div class="weibo_detail">
					  	<div class="blogger_img">
					    		<a href="http://www.weibo.com/<?=$status['uid'];?>" target="_blank">
								<img src="<?=$status['iu'];?>" class="raw_image"></a>
					  	</div>
					  	<div class="weibo_content">
					  		<span class="user_name">
					    		<a href="http://www.weibo.com/<?=$status['uid'];?>" target="_blank"><?=$status['sn'];?></a>：
					    	</span>
					    	<?=$status['mc'];?>&nbsp;详见：<a href='<?=$status['murl'];?>' target='_blank'>
					    		<font color='#0082D1'><?=$status['murl'];?></font></a>
					  	</div>
					  	<div class="weibo_more">
						    <div class="weibo_more_left">
							  	<span class="span1"><?=$status['pt'];?></span>
							  	<span class="span2">来自</span> <span class="span1"><?=$status['srn'];?></span>
							</div>
							<div class="weibo_more_right">
							  	<a href="#">转发(<?=$status['rc'];?>)</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">收藏</a>
							  	<span class="split_font"> | </span>
							  	<a href="#">评论(<?=$status['cc'];?>)</a>
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
			<?=$box_right;?>
		</div>
	</div>
	<!-- eof 页面中部 -->	
	<?=$foot;?>
</div>
</body>
</html>
