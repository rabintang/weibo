<!DOCTYPE html>
<html>
<head>
	<title>登录-知识推荐</title>
	<base href="<?=get_assets_base_url();?>">
  	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  	<link href="css/base.css" type="text/css" rel="stylesheet">
  	<link href="css/index.css" type="text/css" rel="stylesheet">
  	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="all">
		<div class="middle">
			<div class="main_wrap">
				<div class="main">
					<div class="logo">
				    	<img src="img/logo.gif" class="raw_image logoimg" alt="知识推荐">
				  	</div>
				  	<div class="content">
				  		<div class="previewimg">
				    		<img src="img/tag.png" class="raw_image" alt="知识推荐">
				  		</div>
				  		<div class="explain">
				    		<span>微博浩瀚的数据海洋中蕴藏着丰富的知识 <font class="title">知识推荐</font> 为您开启智慧的大门,目前我们暂时为您提供算法和会议的相关知识</span>
				  		</div>
				  		<div class="login_button">
							<a href='<?=$authorize_url;?>' ><img src="img/weibologin.png"></a>
				  		</div>
					</div>
				</div>
			</div>
		</div>
		<?=load_view('modules/foot');?>
	</div>
</body>
</html>
