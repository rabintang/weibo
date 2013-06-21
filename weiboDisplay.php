<?php
session_start();

include_once( 'config.php' );
include_once( 'weiboExtraction.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$c->set_debug( DEBUG_MODE );
//$ms  = $c->home_timeline(); // done
//var_dump($ms);
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
//$user_friends = $c->friends_by_id( $uid );
//数据库操作
//$mysql = new SaeMysql();
$wordExtrac = new knowledgeExtraction();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0043)# -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>我的首页 - 微博释义</title>
<link rel="shortcut icon" href="./favicon.ico">
<link href="./css/base.css" rel="stylesheet" type="text/css">
<link href="./css/tpl_1.css" rel="stylesheet" type="text/css">
<!-- 皮肤目录 -->

<link href="./css/skin.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var __gloCfg={
	'language'	:  'zh_cn',
	'version'	:	'2.1',
	'project'	:	'xwb'
	
};</script>
<script src="./js/jquery.min.js"></script>
<script src="./js/xwb.zh_cn.js"></script>
<script src="./js/extra.js"></script>
<script> 
  try{
  if(navigator.userAgent.indexOf("MSIE")>0)
  {
    window.attachEvent("onload", correctPNG); 
  }}catch(e){}



</script>
</head>
<body id="home" class="own">
<!-- 皮肤设置 开始--> 
<!-- 皮肤设置 结束-->
<div id="wrap">
  <div class="wrap-in"> 
    <!-- 头部 开始-->
    
    <div id="header">
      <div class="nav">
        <div class="inner-nav" id="xwbInnerNav"> <span class="defined-link"> <a href="http://icrc.hitsz.edu.cn/" target="_blank" title="哈工大深研院智能计算研究中心">哈工大ICRC</a>| <a href="http://t.sina.com.cn/" target="_blank">新浪微博</a>| <a href="javascript:addFavorite();">收藏本站</a> </span>
          <div class="nav-right"> <span class="user-link"> <a href="#"><?=$user_message['screen_name']?></a>| <a href="#" target="_blank">关于我们</a>| <a href="#">退出</a> </span> </div>
          <div class="new-tips hidden"><a id="wbs" class="hidden" href="#"><span id="c">0</span>条新微博</a><a id="fans" class="hidden" href="#"><span id="c">0</span>个新粉丝</a><a id="cmts" class="hidden" href="#"><span id="c">0</span>条新评论</a><a id="msgs" class="hidden" href="#"><span id="c">0</span>封新私信</a><a id="refer" class="hidden" href="#"><span id="c">0</span>条微博提到你</a><a id="notify" class="hidden" href="#"><span id="c">0</span>条通知</a><a href="javascript:;" class="ico-close-btn" id="xwb_cls"></a></div>
        </div>
        <div class="nav-bg"></div>
      </div>
      
      <!-- <div class="xad"></div> -->
      
      <div class="inner-header">
        <div align="right"> <br>
          <br>
          <script type="text/javascript" charset="utf-8">
	  var _w = 106 , _h = 58;
	  var param = {
	    url:location.href,
	    type:'5',
	    count:'', /**是否显示分享数，1显示(可选)*/
	    appkey:'3659663781', /**您申请的应用appkey,显示分享来源(可选)*/
	    title:'我正在使用微博词条，发现微博中的新知识，成为知识达人，你也快来试试吧！', /**分享的文字内容(可选，默认为所在页面的title)*/
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
        <h1 class="logo"> <a href="#"> <img src="./images/logo_upload.png" id="logo" alt=""> </a> </h1>
        <div class="hd-xad"> </div>
        <div class="menu">
          <ul class="main-menu">
            <li class="menu-first"><a hidefocus="true" href="#">我的首页</a> </li>
            <!-- 公用闭合LI -->
            <li class=""><a hidefocus="true" href="#">我看排行</a> </li>
            <!-- 公用闭合LI --> 
            <!--            	<li><a hideFocus="true" class="menu-pub" href="/index.php?m=pub">微博广场</a></li>--> 
            <!--                <li><a hideFocus="true" class="menu-user" href="/index.php?m=search.recommend">名人堂</a></li>--> 
            <!--                <li><a hideFocus="true" class="menu-home" href="/index.php?m=index">我的首页</a></li>--> 
            <!--                <li><a hideFocus="true" class="menu-weibo" href="/index.php?m=index.profile">我的微博</a></li>-->
          </ul>
          <div class="menu-bg"> <span class="r-bg"></span> <span class="l-bg"></span> </div>
        </div>
      </div>
    </div>
  
    <!-- 头部 结束-->
    <div id="container">
      <div class="content">
        <div class="main"> 
  
          <!-- 微博列表 开始-->
          
          <div class="feed-list ">
            <div class="title-box">
              <h3>我的首页</h3>
            </div>
           	<!-- 处理数据 开始--> 
		<?php 
		$page = 1;
		while( $page <20 )
		{
			$new_message = $c->home_timeline($page);
			//print_r($new_message);
			if( is_array( $new_message['statuses'] ) ): 
				$result = array();
				foreach( $new_message['statuses'] as $item ): 
					if(!empty($item['retweeted_status']['text']))
					{
						$item = $item['retweeted_status'];
					}
					$text = $wordExtrac->pre_process( $item );
					
					$result = $wordExtrac->rules_en_words( $text,$item );
					if( is_array( $result ) )
					{
						$temp = $wordExtrac->rules_abbr($text,$item);
						if( is_array( $temp ) )
						{
							$result = array_merge($result,$temp);
						}
					}
					else
					{
						$result = $wordExtrac->rules_abbr($text,$item);
					}
					if( is_array( $result ) )
					{
						$temp = $wordExtrac->rules_en_years($text,$item);
						if( is_array( $temp ) )
						{
							$result = array_merge($result,$temp);
						}
					}
					else
					{
						$result = $wordExtrac->rules_en_years($text,$item);
					}
					if( is_array( $result ) )
					{
						foreach($result as $keywords => $msg)
						{
							display_result( $keywords , $msg );
						}
					}
				endforeach; 	
			endif;
			$page = $page + 1;
		}
		
		?>
		<!-- 处理数据 结束--> 
		<?php
		function display_result( $keywords , $msg )
		{?>
			<!-- 微博列表 -->
		    <div>
		      <ul id="xwb_weibo_list_ct" name="0">
		        <!-- 主微博 -->
			<?php
				$user_message = $msg['user'];
			?>
		        <li rel="w:3554303878504132" id="3554303878504132&amp;0">
			  <!-- 熟悉 -->
		          <div class="user-pic"> <a href="<?=$user_message['profile_image_url']?>"><img width="50" height="50" src="<?=$user_message['profile_image_url']?>" alt="<?=$user_message['screen_name']?>" title="<?=$user_message['screen_name']?>"></a> 
		            <!-- 在线直播 主持人和嘉宾的区别 --> 
		            <!-- end --> 
		          </div>
		          <div class="feed-content">  
		            <p class="feed-main"> <a href="#" title="<?=$user_message['screen_name']?>"><?=$user_message['screen_name']?></a><br><?=$msg['text']?></p>
		            <div align="right" id="imgdiv_3554303878504132"> <br>
		            </div>
		            <p></p>
		            <br>
		            <a href="javascript:showMoreStatus('dicid1','wbid1');" id="a_3554303878504132"> #<?=$keywords?>#</a><br>
		            <div class="feed-info">
		              <p><a href="#" rel="e:dl">删除</a>| <a href="#" rel="e:fw" id="fw">转发(<?=$msg['reposts_count']?>)</a>| <a href="#" rel="e:fr">收藏</a>| <a href="javascript:;" rel="e:cm" id="cm">评论(<?=$msg['comments_count']?>)</a></p>
		              <span><a href="#"><?=$msg['created_at']?></a> 来自 <?=$msg['source']?></span>
		              <p> <span> </span> </p>
		            </div>
		          </div>
		          <!-- 熟悉 --> 
		        </li>
		        <!--end 主微博 --> 		        
		      </ul>
		    </div>
            
       		 <!-- end 微博列表 --> 
		<?php
		}
		?>
            
            
          </div>
          <!-- 微博列表 结束--> 
          <!-- 微博列表 结束--> 
        </div>
      </div>
      <div class="aside"> 
        <!-- 用户信息 开始-->
        <div class="user-preview">
          <div class="user-info"> <a class="user-pic" href="#"><img src="<?=$user_message['profile_image_url']?>" title="<?=$user_message['screen_name']?>"></a>
            <div class="user-intro"> <strong> <?=$user_message['screen_name']?> </strong>
              <p class="ico-male"><?=$user_message['location']?></p>
            </div>
          </div>
          <!-- 用户关注、粉丝、微博信息总数 开始-->
          <div class="user-total-box">
            <div class="first">
              <p><a id="xwb_user_total_follow" class="user-total " href="#"><?=$user_message['friends_count']?></a></p>
              <a href="#">关注</a> </div>
            <div>
              <p><a id="xwb_user_total_fans" class="user-total " href="#"><?=$user_message['followers_count']?></a></p>
              <a href="#">粉丝</a> </div>
            <div>
              <p><a id="xwb_user_total_wb" class="user-total " href="#"><?=$user_message['statuses_count']?></a></p>
              <a href="#">微博</a> </div>
          </div>
          <p></p>
        </div>
        <!-- 用户标签 开始-->
        <div class="mod-aside user-tag">
          <div class="hd">
            <h3>热门词条</h3>
          </div>
          <div class="bd"> <a href="#">NLP</a> <a href="#">ML</a> <a href="#">IR</a> <a href="#">ACM</a>
						   <a href="#">MT</a> <a href="#">AI</a> <a href="#">IEEE</a> <a href="#">ACL</a></div>
        </div>
      </div>
    </div>
    <!-- 尾部 开始 -->
    <div class="ft-xad"> </div>
    <div id="footer">
      <div class="ft-in">
        <div class="ft-bg"></div>
        <!-- ad页脚800 开始 --> 
        <!--<div class="xad-box xad-box-p4">
			<a href="#" class="ico-close-btn"></a>
		</div>--> 
        <!-- ad页脚800 结束 -->
        <div class="ft-con">
          <div class="footer-defined"> <em class="site-name"> 微博释义 <a target="_blank" href="#">&nbsp;</a> </em> </div>
          <span>Copyright © 2013 <a href="http://icrc.hitsz.edu.cn/" target="_blank">哈工大深研院智能计算研究中心</a></span> </div>
      </div>
    </div>
    <!-- 底部 结束--> 
  </div>
</div>
<a href="#" class="gotop hidden" id="gotop" style="bottom: 95px;"> <span class="gotop-bg"></span> <span class="txt"><em class="arrow">&lt;</em><span>返回顶部</span></span> </a>
</body>
</html>
