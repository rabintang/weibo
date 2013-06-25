<!-- bof 右侧导航栏 -->
<div class="box_right">
	<div class="inner_wrap">
		<div class="user_stat">
			<dl>
				<dt>
					<a href="http://www.weibo.com/<?=$_SESSION['uid'];?>">
						<img src="<?=$_SESSION['uinfo']->iu?>" alt="<?=$_SESSION['uinfo']->sn;?>" /></a>
				</dt>
				<dd>
					<a href="http://www.weibo.com/<?=$_SESSION['uid'];?>" title="<?=$_SESSION['uinfo']->sn;?>">
						<?=$_SESSION['uinfo']->sn;?></a>
				</dd>
			</dl>
			<ul class="user_atten">
				<li>
					<dl><dt>关注：</dt><dd><?=$_SESSION['uinfo']->an;?></dd></dl>
				</li>
				<li>
					<dl><dt>粉丝：</dt><dd><?=$_SESSION['uinfo']->fn;?></dd></dl>
				</li>
				<li>
					<dl><dt>微博：</dt><dd><?=$_SESSION['uinfo']->mn;?></dd></dl>
				</li>
			</ul>
		</div>
	  	<div class="catalog">
		    <div class="cat_tittle">
				<span>词条目录</span>
			</div>
			<div class="cat_line_wrap">
				<div class="cat_line">
			    </div>
			</div>
			<? Tool::echo_rnavig($rpage,rpagesize,NULL);?>
			<div class="voc_navi">
				<a href="<?Tool::echo_rnavigurl($rpage,1,$param,$pagebase);?>">
					<div class="voc_navi_pre">
				    	<span>∧</span>
					</div>
				</a>
				<a href="<?Tool::echo_rnavigurl($rpage,2,$param,$pagebase);?>">
					<div class="voc_navi_next">
						<span>∨</span>
					</div>
				</a>
			</div>
	  	</div>
  	</div>
</div>
<!-- eof 右侧导航栏 -->