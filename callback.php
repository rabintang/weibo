<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
//$o->set_debug( DEBUG_MODE );

if (isset($_REQUEST['code'])) {
	$keys = array();

	// 验证state，防止伪造请求跨站攻击
	//$state = $_REQUEST['state'];	
	/*if ( empty($state) || $state !== $_SESSION['weibo_state'] ) {
		echo '非法请求！';
		exit;
	}
	unset($_SESSION['weibo_state']);*/

	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
		if ($token) {
        	$_SESSION['token'] = $token;
        	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
        	//include_once( 'preprocess.php' );
        	echo '<div style="margin:0 auto;"><span>授权完成,第一次进入系统，正在努力为您加载词条，请稍后!</span></div>';
        	include('userinit.php');
        	header("Location: main.php");
        } else {
            echo '授权失败。';
        }
	} catch (OAuthException $e) {
	    echo '授权失败。';
	}
} else {
    echo '授权失败。';
}
?>
