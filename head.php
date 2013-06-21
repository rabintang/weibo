<?php
    if(!isset($_SESSION['uid']) || $_SESSION['uid'] == NULL){        
	     session_start();
	     include_once( 'config.php' );
	     include_once( 'saetv2.ex.class.php' );
	     $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
	     $c->set_debug( DEBUG_MODE );
	     $uid_get = $c->get_uid();
	     $uid = $uid_get['uid'];
	     $_SESSION['uid'] = $uid;    
    }
    include_once 'includes/conn.php';
    include_once 'includes/tool.php'
?>

<!-- 页首导航栏
    ================================================== -->
<div  class="header" >
  <center>
    <div class="header_container">
      <div class="logo">
        <a href="main.php" ><img src="img/logo.png" class="raw_image" alt="知识推荐"></a>
      </div>

      <div class="tab_all">
        <a href="main.php" >全部</a>
      </div>
      <?
        $sql = "SELECT * FROM  `category`";
        $result = Conn::select($sql);
        while($row = mysql_fetch_array($result)){
      ?>
      <div class="tab_meeting">
        <a href="main.php?type=<?php echo($row['cgid']);?>" ><?php echo($row['cgn']);?></a>
      </div>
      <?
        }
        //Conn::close($conn);
      ?>

      <div class="search">
        <form action="search.php" method="get" target="_self" title="请输入词条">
          <INPUT name="word" id="search" type=text value="请输入词条" class="search_input" onClick="this.value='';" onBlur="this.value='请输入词条';">
          <INPUT type="submit" class="search_sub" value="搜索词条" ></form>
      </div>

      <div class="uname">
        <span class="uname_font"><a href="#"><?php echo(Tool::get_screen_name($_SESSION['uid']));?></a></span>
        <span class="split_font">|</span>
        <a href="#">
          <span class="exit_font">退出</span>
        </a>
      </div>

      <div class="share_button">
          <a href="main.php" ><img src="img/share_button_top.gif"  class="raw_image"></a>
      </div>
	</div>
	</center>
</div>
<!-- end 页首导航栏 -->