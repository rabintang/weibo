<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<link href="css/main_progress.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
<script type="text/javascript" src="js/script.js"></script>
<title>正在加载知识...</title>
</head>
<body>
    <div class="example">
        <div id="progress1">
            <!--<div class="percent"></div>-->
			<span align="center"><h3>正在加载知识...</h3></span>
            <div class="pbar"></div>
             <!--<div class="elapsed"></div>-->
		 <?php
	     //session_start();
	     //include_once( 'config.php' );
	     //include_once( 'saetv2.ex.class.php' );
	     $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
	     $c->set_debug( DEBUG_MODE );
	     $uid_get = $c->get_uid();
	     $uid = $uid_get['uid'];
	     $_SESSION['uid'] = $uid;
	     //echo $uid;
	     echo $_SESSION['uid'];
	     ?>
        </div>
		hello world!
		<?php
		echo $uid;
	     ?>
    </div>
</body>
</html>