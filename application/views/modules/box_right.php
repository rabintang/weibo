<!-- bof 右侧导航栏 -->
<?php $user = get_session('user');?>
<div class="box_right">
	<div class="inner_wrap"><?php
		if($user){?>
		<div class="user_stat">
			<dl>
				<dt>
					<a href="http://www.weibo.com/<?=$user['uid'];?>" target="_blank">
						<img src="<?=$user['iu']?>" alt="<?=$user['sn'];?>" /></a>
				</dt>
				<dd>
					<a href="http://www.weibo.com/<?=$user['uid'];?>" title="<?=$user['sn'];?>" target="_blank">
						<?=$user['sn'];?></a>
				</dd>
			</dl>
			<ul class="user_atten">
				<li>
					<dl><dt>关注：</dt><dd><?=$user['an'];?></dd></dl>
				</li>
				<li>
					<dl><dt>粉丝：</dt><dd><?=$user['fn'];?></dd></dl>
				</li>
				<li>
					<dl><dt>微博：</dt><dd><?=$user['mn'];?></dd></dl>
				</li>
			</ul>
		</div><?php
		}?>
	  	<div class="catalog">
		    <div class="cat_tittle">
				<span>词条目录</span>
			</div>
			<div class="cat_line_wrap">
				<div class="cat_line">
			    </div>
			</div>
			<ul class='voc'><?php
				foreach($abbres as $abbre){?>
					<li><a href='<?=site_url("detail/index/{$abbre['abrid']}");?>' onclick='goto('voc1')' target="_blank">
						<?=$abbre['kl'];?></a><a href='<?=site_url("detail/index/{$abbre['abrid']}");?>' class='detail' target="_blank">[详细]</a></li><?php
				}?>
			</ul>
			<div class="voc_navi">
				<a href="<?=get_rnavigurl(0);?>">
					<div class="voc_navi_pre">
				    	<span>∧</span>
					</div>
				</a>
				<a href="<?=get_rnavigurl(1);?>">
					<div class="voc_navi_next">
						<span>∨</span>
					</div>
				</a>
			</div>
	  	</div>
  	</div>
</div>
<!-- eof 右侧导航栏 -->
