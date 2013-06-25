<?php
  include_once 'includes/conn.php';
  include_once 'includes/tool.php';
 
  $_SESSION['uid'] = '2100610530';       
  if(!isset($_SESSION['uid']) || $_SESSION['uid'] == Null){ 
    session_start();
    include_once( 'config.php' );
    include_once( 'saetv2.ex.class.php' );
    $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
    $c->set_debug( DEBUG_MODE );
    $uid_get = $c->get_uid();
    $uid = $uid_get['uid'];
    $_SESSION['uid'] = $uid;
	}
  if(!isset($_SESSION['uinfo']) || $_SESSION['uinfo'] == Null)
    $_SESSION['uinfo'] = Tool::get_user_info($_SESSION['uid']);
?>

<!-- bof 页首导航栏 -->
<div  class="header" >
  <center>
    <div class="header_container">
      <div class="logo">
        <a href="main.php" ><img src="img/logo.gif" class="logo" alt="知识推荐"></a>
      </div>

      <div class="categories">
        <ul>
          <li><a href="main.php" >全部</a></li>
          <?
            $sql = "SELECT * FROM  `category`";
            $result = Conn::select($sql);
            while($row = mysql_fetch_array($result)){
          ?>
            <li class="split_font_cat">|</li>
            <li class="category"><a href="main.php?type=<?php echo($row['cgid']);?>" ><?php echo($row['cgn']);?></a></li>
          <?
            }
            Conn::close();
          ?>
        </ul>
      </div>
      <div class="search">
        <form name="sword" action="search.php" method="get" target="_self" title="请输入词条">
          <i class="txt">
            <input name="word" id="search" type=text value="请输入词条" class="search_input" 
              onClick="this.value='';" onBlur="this.value='请输入词条';">
            <a href="javascript:void(0);document.sword.submit();" title="搜索"></a>
          </i>
        </form>
      </div>
      <div class="share_button">
          <a href="main.php" ><img src="img/share_button_top.gif"  class="share_image"></a>
      </div>
      <div class="uname">
        <span class="uname_font"><a href="#"><?=$_SESSION['uinfo']->sn;?></a></span>
        <span class="split_font">|</span>
        <a href="#">
          <span class="exit_font">退出</span>
        </a>
      </div>
	</div>
	</center>
</div>
<!-- eof 页首导航栏 -->