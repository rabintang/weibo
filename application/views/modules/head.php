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
		<input name="word" id="search" type="text" value="请输入词条" class="search_input" onClick="this.value='';" onBlur="this.value='请输入词条';">
            	<a onclick="document.sword.submit();" title="搜索"></a>
          </i>
        </form>
      </div>
      <div class="share_button">
	  <script type="text/javascript" charset="utf-8">
	   var _w = 106 , _h = 58;
	   var param = {
	     url:location.href,
	     type:'5',
	     count:'', /**是否显示分享数，1显示(可选)*/
	     appkey:'244566215', /**您申请的应用appkey,显示分享来源(可选)*/
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
      <div class="uname">
        <span class="uname_font"><a href="http://www.weibo.com/<?=get_session('uid')?>" target="_blank"><?=get_session('user/sn');?></a></span>
        <span class="split_font">|</span>
        <a href="<?=site_url('user/login_out');?>">
          <span class="exit_font">退出</span>
        </a>
      </div>
	</div>
	</center>
</div>
<!-- eof 页首导航栏 -->
