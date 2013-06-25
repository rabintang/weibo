<!DOCTYPE html>
<html>
<head>
  <title>CGI搜索结果-知识推荐</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <link href="css/base.css" type="text/css" rel="stylesheet">
  <link href="css/main.css" type="text/css" rel="stylesheet">
  <link href="css/nofound.css" type="text/css" rel="stylesheet">
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="all">
		<?php include 'includes/tool.php';?>
	  	<?php include 'head.php';?>	
	  	<div class="middle">
		<!-- bof 页面中部 -->
		<div class="main_wrap">
			<?
				$kl = Tool::get("word");
				if(empty($kl) || $kl == "")
					echo "<script>window.location ='404.php';</script>";
			?>
			<!-- bof 词条列表 -->
			
			<div class="main">
			  <div class="search_title">
			    <span class="span1">搜索</span>
			    <span class="span2"><?echo($kl);?></span>
			    <span class="span3">的结果</span>
			    <span class="span4">(共0条)</span>
			  </div>
			  <div class="explain">
			    <span>找不到和您的查询 "<font color="#FF0000"><?echo($kl);?></font>" 相关的词条。</span>
			  </div>
			  <div class="ititle">
			    <span><font color="#FF0000"><?echo($kl);?></font> 的网页搜索结果：</span>
			  </div>
			  <!-- 网页搜索结果1 -->
			  <div class="webresult">
			  	<div class="webresult_title">
				  <span><a href="baike.baidu.com/"><font color="#FF0000">cgi</font>_百度百科</a></span>
				</div>
			  	<div class="webresult_content">
				  <span>作为一个英文缩写，该名词有不同含义，包括“通用网关界面”、“计算机合成图像/电脑三维动画”、“计算机图形接口标准”、“全球小区识别码”等。</span>
				</div>
			  	<div class="webresult_link">
				  <span>baike.baidu.com/ 2013-02-01</span>
				</div>
			  	<div class="webresult_resource">
				  <span>来源：百度百科</span>
				</div>
			  </div>
			  <!-- end 网页搜索结果1 -->
			  <!-- 网页搜索结果2 -->
			  <div class="webresult">
			  	<div class="webresult_title">
				  <span><a href="baike.baidu.com/"><font color="#FF0000">CGI</font>- 维基百科,自由的百科全书</a></span>
				</div>
			  	<div class="webresult_content">
				  <span><font color="#FF0000">CGI</font>维基百科,自由的百科全书跳转至: 导航、 搜索 <font color="#FF0000">CGI</font>可以指: 通用网关接口 (Common Gateway Interface),一个在Web服务器中使用的技术。 计算机图形界面:一种位于...</span>
				</div>
			  	<div class="webresult_link">
				  <span>zh.wikipedia.org/wiki/CGI 2013-3-9</span>
				</div>
			  	<div class="webresult_resource">
				  <span>来源：维基百科</span>
				</div>
			  </div>
			  <!-- end 网页搜索结果2 -->
			  <!-- 网页搜索结果3 -->
			  <div class="webresult">
			  	<div class="webresult_title">
				  <span><a href="baike.baidu.com/"><font color="#FF0000">CGI</font>入门</a></span>
				</div>
			  	<div class="webresult_content">
				  <span><font color="#FF0000">CGI</font>脚本是什么?它是怎样工作的 一个<font color="#FF0000">CGI</font>脚本输出象什么? 怎样用参数或无参数创建一个<font color="#FF0000">CGI</font>脚本 怎样创建一个返回规定响应的<font color="#FF0000">CGI</font>脚本 怎样创建一个输入表单的<font color="#FF0000">CGI</font>脚本 有...</span>
				</div>
			  	<div class="webresult_link">
				  <span>www.jdon.com/idea/cgi.htm 2013-3-25</span>
				</div>
			  	<div class="webresult_resource">
				  <span>来源：百度</span>
				</div>
			  </div>
			  <!-- end 网页搜索结果3 -->
			</div>
			<!-- end 词条列表 -->
		</div>
		</div>
		<!-- end 页面中部 -->
		<?php include 'foot.php';?>
	</div>
</body>
</html>