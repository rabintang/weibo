<!DOCTYPE html>
<html>
<head>
  	<title>自然语言处理搜索结果-知识推荐</title>
	<base href="<?=get_assets_base_url();?>" />
  	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  	<link href="css/base.css" type="text/css" rel="stylesheet">
  	<link href="css/main.css" type="text/css" rel="stylesheet">
	<link href="css/pagination.css" type="text/css" rel="stylesheet">
  	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  	<script type="text/javascript" src="js/global.js"></script>
	<script type="text/javascript">
		$(function(){
			$(".pagination").children("a").each(function(){
				$(this).click(function(){$("#sword").submit();});
			})
		});
	</script>
</head>
<body>
<div class="all">
  	<?=$head;?>
	<form id="sword" name="sword" action="<?=site_url("search/index");?>" method="post" target="_self">
	    <input name="word" type="text" value="<?=$key_word?>" style="display:none;" />
	</form>
  	<div class="middle">
	<!-- bof 页面中部 -->
	<form name="recordActionFrm" id="recordActionFrm" method="post" action='detail'>
		<input id="sourceField" type="hidden" name="source" value="">
	</form>
	<div class="main_wrap">
		<!-- bof 词条列表 -->		
		<div class="main">
		  	<div class="search_title">
			    <span class="span1">搜索</span>
			    <span class="span2"><?=$key_word;?></span>
			    <span class="span3">的结果</span>
			    <span class="span4">(共<?=$total_rows;?>条)</span>
		  	</div><?php
			foreach($items as $item) {?>
		  	<!-- bof 词条 -->
		  	<div class="voc_main" id="voc1">
			<div class="content_a"><?php
				$output = "<p><a onclick=\"javascript:recordAction('" . site_url("detail/index/" .
					$item['abbre']['abrid']) . "', 'searchfound');return false;\"/>";
				echo $output;
			?>
			<span><?=$item['abbre']["kl"];?></span></a>
				&nbsp;&nbsp;<?=$item['abbre']["bf"];?></p>
			</div><?php
			if(isset($item['relate_abbres'])) {
				echo get_relate_abbres($item['relate_abbres'], 'searchfound');
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
			<!-- end 微博列表 -->
			</div>
			<!-- end 词条 --><?php
		    }?>		  
		  	<!-- 分页 -->
		  	<?=$pagination?>
		  	<!-- end 分页 -->		  
		</div>
		<!-- end 词条列表 -->		
		<?=$box_right;?>
		</div>
	</div>
	<!-- end 页面中部 -->	
	<?=$foot;?>
</div>
</body>
</html>