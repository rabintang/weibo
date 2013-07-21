<!-- bof 页首导航栏 -->
<div  class="header" >
  <center>
    <div class="header_container">
      <div class="logo">
        <a href="<?=site_url('main/index');?>" ><img src="img/logo.gif" class="logo" alt="知识推荐"></a>
      </div>
      
      <div class="categories">
        <ul>
          <li><a href="<?=site_url('main/index');?>" >全部</a></li><?php
            foreach($categories as $category) {?>
              <li class="split_font_cat">|</li>
              <li class="category"><a href='<?=site_url("main/index/{$category['cgid']}");?>' ><?=$category['cgn'];?></a></li><?php
            }?>
        </ul>
      </div>
      <div class="search">
        <form name="sword" action="<?=site_url("search/index");?>" method="post" target="_self" title="请输入词条">
          <i class="txt">
            <input name="word" id="search" type="text" value="请输入词条" class="search_input" 
              onClick="this.value='';" onBlur="this.value='请输入词条';">
            <a onclick="document.sword.submit();" title="搜索"></a>
          </i>
        </form>
      </div>
      <div class="share_button">
          <a href="<?=site_url('main/index');?>" ><img src="img/share_button_top.gif"  class="share_image"></a>
      </div>
      <div class="uname">
        <span class="uname_font"><a href="#"><?=get_session('user')['sn'];?></a></span>
        <span class="split_font">|</span>
        <a href="#">
          <span class="exit_font">退出</span>
        </a>
      </div>
	</div>
	</center>
</div>
<!-- eof 页首导航栏 -->