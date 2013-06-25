<?php
session_start();
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$o->set_debug( DEBUG_MODE );
// 生成state并存入SESSION，以供CALLBACK时验证使用
$state = uniqid( 'weibo_', true);
$_SESSION['weibo_state'] = $state;
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL , 'code', $state );
?>
<!DOCTYPE html>
<html>
<head>
	<title>登录-知识推荐</title>
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
				    		<a href='<?=$code_url?>' ><img src="img/weibologin.png"></a>
				  		</div>
					</div>
				</div>
			</div>
		</div>
		<!-- bof 页脚 -->
		<?php include('foot.php');?>
		<!-- end 页脚 -->
	</div>
</body>
</html>