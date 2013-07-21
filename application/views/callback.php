<?php
	if($authorize_success) {
    	//include_once( 'preprocess.php' );
    	echo '<div style="margin:0 auto;"><span>授权完成,第一次进入系统，正在努力为您加载词条，请稍后!</span></div>';
    	include('userinit.php');
    	header("Location: main.php");
	} else {
	    echo '授权失败。';
	}
?>