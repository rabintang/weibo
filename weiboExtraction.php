<?php
Class knowledgeExtraction {

	//预处理，去掉URL，@的用户等
	public function pre_process($item)
	{
		$text = $item['text'];
//		$text = $item['text']." ".$item['retweeted_status']['text'];//加上转发的文本
//		if(!empty($item['retweeted_status']['text']))
		if(preg_match_all('/http:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/',$text,$weibourls))#去URL
		{
			foreach($weibourls[0] as $vari)
			{
				$start = strpos($text,$vari);
				$text = substr_replace($text,'',$start,strlen($vari));
			}
		}
		if(preg_match_all('/@(.)+?[\s]+?/',$text,$result))#去掉@的用户
		{
			foreach($result[0] as $vari)
			{
				$start = strpos($text,$vari);
				$text = substr_replace($text,'',$start,strlen($vari));
			}
		}
		return $text;
	}//end of pre_process
	
	//技术，算法前面的英文词
	public function rules_en_words( $text,$item )
	{
		if( strpos($text,'技术') === false )
		{
			;
		}
		else
		{
			if(preg_match_all('/[A-Za-z]{2,10}[\s&-]*[A-Za-z]{2,10}技术/',$text,$result))#匹配XXX技术
			{
				foreach($result[0] as $vari)
				{
					$start = strpos($vari,'技术');
					$vari = substr_replace($vari,'',$start,strlen( '技术' ));
				//	echo $vari.'技术<br>';
					$result_list[$vari] = $item;
				//	print_r( $result_list );
				}
			}
		}
		if( strpos($text,'算法') === false )
		{
			;
		}
		else
		{
			if(preg_match_all("/[A-Za-z]{2,10}[\s&-]*[A-Za-z]{2,10}算法/",$text,$result))//匹配XXX算法
			{
				foreach($result[0] as $vari)
				{
					$start = strpos($vari,'算法');
					$vari = substr_replace($vari,'',$start,strlen( '算法' ));
			//		echo $vari.'算法<br>';
					$result_list[$vari] = $item;
				}
			}
		}
		
		return $result_list;
	}//end of rules_en_words

	public function rules_abbr($text,$item)
	{
		$reg_str = "";
		if(preg_match_all('/[A-Z]{2,10}/',$text,$result))//获取英文缩写
		{
			foreach($result[0] as $vari)
			{
				$length = strlen($vari);
				for ($i = 0;$i < $length;$i++)
				{
					$reg_str = $reg_str . $vari[$i] . '[a-z]{2,15}[\s]*';
				}
				if(preg_match_all('/'.$reg_str.'/',$text,$en_abbr))//获取英文缩写的全称
				{
					foreach($en_abbr[0] as $vari)
					{
						$result_list[$vari] = $item;
					}	
				}
			}
		}
		return $result_list;
	}
	public function rules_en_years($text,$item)
	{
		if( strpos($text,'技术') === false && strpos($text,'tutorial') === false && strpos($text,'accept') === false && strpos($text,'reject') === false && strpos($text,'poster') === false && strpos($text,'Tutorial') === false && strpos($text,'截稿') === false && strpos($text,'主题报告') === false && strpos($text,'Conference') === false && strpos($text,'Calls for') === false && strpos($text,'paper') === false && strpos($text,'算法') === false )
		{
			return ;
		}
		else
		{
			$strA = "201";
			$strB = "'1";
			if( strpos($text,$strA) === false)
			{
				return ;
			}
			else
			{
				if(preg_match_all( '/[A-Za-z0-9]{2,10}[\s&-]*[A-Za-z0-9]{0,10}[\s-]*?201/' , $text , $result) )//获取后面带201*字样的英文词
				{
					foreach($result[0] as $vari)
					{
						$start = strpos($vari,$strA);
						$vari = substr_replace($vari,'',$start,strlen( $strA ));
						if( strpos($vari,'-') != false)
						{
							$start = strpos($vari,'-');
							$vari = substr_replace($vari,'',$start,strlen( '-' ));
						}
						$result_list[$vari] = $item;
					//	echo $vari."201<br>";
					}
				}
			}
			if( strpos($text,$strB) === false)
			{
				return ;
			}
			else
			{
				if(preg_match_all( '/[A-Za-z0-9]{2,10}[\s&-]*[A-Za-z0-9]{0,10}[\s-]*?\'1/', $text , $result ) )//获取后面带'12字样的英文词
				{
					foreach($result[0] as $vari)
					{
						$start = strpos($vari,$strB);
						$vari = substr_replace($vari,'',$start,strlen( $strB ));
						$result_list[$vari] = $item;
					//	echo $vari."‘1<br>";
					}
				}
			}
		}
		print_r($result_list);
		return $result_list;
	}//end of rules_en_years
}
?>
