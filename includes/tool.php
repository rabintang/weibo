<?
mb_internal_encoding("UTF-8"); //Set the internal encoding method is UTF-8
class Tool {
    /**
    * 计算UTF8中英文混合字符串的长度
    * 中文算两个字符，英文数字算一个字符
    * @return $length
    */
    private static function UTF8_length($str) {
        $length=0;
        $asclen=strlen($str);
        $ind=0;
        for($ind=0;$ind<$asclen;) {
                if(ord(substr($str,$ind,1))>0x7F) {
                        $length = $length + 2;
                        $ind = $ind + 3;
                } else {
                        $length++;
                        $ind++;
                }
        }
        return $length;
    }
    
    /**
     * 从UTF8中英文混合字符串中截取字符串
     * 中文算两个字符，英文数字算一个字符，截有半个汉字时取完整汉字
     * @parm $str, $start, $length
     * @return $length
     */
    private static function UTF8_substr($str, $start, $length) {
        $alllen=0;
        $ind=0;
        $asclen=strlen($str);
        $isasc = true;
        $ret_str = "";
        for($ind=0;$ind<$asclen;){
            if(ord(substr($str,$ind,1))>0x7F) {
                $isasc = false;
                $char = substr($str,$ind,3);
            }else{
                $isasc = true;
                $char = substr($str,$ind,1);
            }
            if($alllen >= $start)
                $ret_str .= $char;
            if($isasc) {
                $alllen++;
                $ind++;
            }else{
                $alllen = $alllen + 2;
                $ind = $ind + 3;
            }
            if(($length > 0) & ($alllen >= ($start + $length))) break;
        }
        return $ret_str;
    }
    
    /**
     * 从UTF8中英文混合字符串中确定给定字符串的位置
     * 中文算两个字符，英文数字算一个字符，返回字符数
     * @return $position
     */
    private static function UTF8_stripos($source, $key){
        $pos = stripos($source,$key);
        $blen = 0;
        if($pos){
            $blen = Tool::UTF8_length(substr($source,0,$pos));
        }
        return $blen;
    }
    
    public static function get_screen_name($uid){
        $uid = trim($uid);
        $query = "SELECT sn FROM `userlist` WHERE uid=$uid";
        $result = Conn::select($query);
        $screen_name = '';
        if(mysql_num_rows($result) > 0){
            $row = mysql_fetch_array($result);
            $screen_name = $row['sn'];
        }
        return $screen_name;
    }
    
	public static function convert($str,$default) {
		$num;
		if(!empty($str)) {
			try{
				$num = (int)$str;
			} catch(Exception $e) {
				$num = $default;
			}
		} else {
			$num = $default;
		}
		return $num;
	}

	public static function get($str){
	    $val = !empty($_GET[$str]) ? $_GET[$str] : NULL;
	    return $val;
	}

	//Echo relative link of a knowledge.
	public static function echo_relatelink($row) {
		if(!empty($row["wk"]) || !empty($row["bk"])) {
			$str = "<div class='relate_link'><span >相关链接: </span>";
		} else {
			return;
		}
		if(!empty($row["wk"])) {
			$str = $str."<a href='{$row["wk"]}' target='_blank'>维基百科释义</a>";
			if(!empty($row["bk"])) {
				$str = $str."<span class='split_font'> | </span><a href='{$row['bk']}' target='_blank'>百度百科释义</a>";
			}
		} else {
			$str = $str."<a href='{$row['bk']}' target='_blank'>百度百科释义</a>";
		}
		$str = $str."</div>";
		echo($str);
	}

	//Echo relative bloger with an assigned number.
	public static function echo_relatebloger($item,$num){
		$sql = "SELECT uid,sn FROM `weibomsg` WHERE mid in (SELECT t.mid FROM (SELECT mid FROM `abbre_weibomsg` WHERE abrid={$item['abrid']}) AS t) 
			AND sn!='' GROUP BY uid LIMIT $num";
		$result = Conn::select($sql);
		if(!empty($result) && mysql_num_rows($result) > 0) {
			$row = mysql_fetch_array($result);
			$str = "<a href='http://www.weibo.com/{$row["uid"]}' target='_blank'>@{$row["sn"]}</a>";
			while($row = mysql_fetch_array($result)){
				$str = $str."<span class='split_font'> | </span><a href='http://www.weibo.com/{$row["uid"]}' target='_blank'>@{$row["sn"]}</a>";
			}
			$str = $str."...";
			echo($str);
		}
	}

	//Echo relative knowledge with an assigned number.
	public static function echo_relateknowledge($item,$num){
		$sql = "SELECT abrid,kl FROM `abbreviation` WHERE abrid IN (SELECT t.tabrid FROM 
				(SELECT tabrid FROM `abbre_abbre` WHERE oabrid={$item['abrid']} LIMIT $num) AS t)";
		$result = Conn::select($sql);
		if(mysql_num_rows($result) > 0) {
			$row = mysql_fetch_array($result);
			$str = "<div class='relate_voc'><span>相关词条: </span><a href='detail.php?abbre={$row['abrid']}'>{$row['kl']}</a>";
			while($row = mysql_fetch_array($result)) {
				$str = $str."<span class='split_font'> | </span><a href='detail.php?abbre={$row["abrid"]}'>{$row['kl']}</a>";
			}
			$str = $str."</div>";
			echo($str);
		}
		Conn::close();
	}

	//Handle a microblog message.
	private static function _handle_wbmsg($row,$kl){
		$totallen = 110; //The length of a line(including screen name, microblog message, publish time).
		/*$restlen = $totallen - Tool::UTF8_length($row["sn"]) - Tool::UTF8_length($kl) - strlen($row['murl']) - strlen($row['pt']);
		$bpos = Tool::UTF8_stripos($row["mc"],$kl);
		$str = "<div class='weibo'><div class='weibo_blogger'><a href='http://www.weibo.com/{$row["uid"]}'";
		$str = $str." target='_blank'>{$row["sn"]}</a>: </div><div class='weibo_content'><span>";		 
		$klen = Tool::UTF8_length($kl);
		if($bpos){
			if($bpos >= $restlen / 2) {
				$str = $str.'...'.Tool::UTF8_substr($row['mc'],$bpos-$restlen/2,$restlen/2)."<font color='#FF0000'>".
				    Tool::UTF8_substr($row['mc'],$bpos,$klen)."</font>";
				$str = $str.Tool::UTF8_substr($row['mc'],$bpos+$klen,$restlen/2);
			} else {
				$str = $str.Tool::UTF8_substr($row['mc'],0,$bpos)."<font color='#FF0000'>$kl</font>";
				$str = $str.Tool::UTF8_substr($row['mc'],$bpos+$klen,$restlen-$bpos);
			}
		} else {
			$str = $str.Tool::UTF8_substr($row['mc'],0,$restlen+$klen);
		}
		if(Tool::UTF8_length($row['mc']) > $totallen-Tool::UTF8_length($row['sn'])){
			$str = $str."...";
		}
		if(!empty($row['murl'])){
			$str = $str."<a href='{$row["murl"]}' target='_blank'><font color='#0082D1'>{$row["murl"]}</font></a>";
		}
		$str = $str."</span></div>";
		if(!empty($row['pt'])){
			$str = $str."<div class='weibo_time'><span>{$row["pt"]}</span></div>";
		}
		$str = $str.'</div>';
		return $str;*/
		$restlen = $totallen - Tool::UTF8_length($row["sn"]) - strlen($row['pt']);
		$str = "<div class='weibo'><div class='weibo_blogger'><a href='http://www.weibo.com/{$row["uid"]}'";
		$str = $str." target='_blank'>{$row["sn"]}</a>: </div><div class='weibo_content'><span>";
		$str .= Tool::UTF8_substr($row['mc'],0,$restlen) . '...';
		if(!empty($row['murl'])){
			$str = $str."<a href='{$row["murl"]}' target='_blank'><font color='#0082D1'>[详见]</font></a>";
		}
		$str = $str."</span></div>";
		if(!empty($row['pt'])){
			$str = $str."<div class='weibo_time'><span>{$row["pt"]}</span></div>";
		}
		$str = $str.'</div>';
		return $str;
	}

	public static function get_fui($uid){
		$sql = "SELECT fui FROM `userlist` WHERE uid='{$uid}'";
		$result = Conn::select($sql);
		$fui = NULL;
		if(mysql_num_rows($result) > 0){
			$fui = mysql_fetch_row($result);
			$fui = $fui[0];
			if($fui == Null || trim($fui) == '')
			      $fui = Null;
		}
		return $fui;
	}

	//Echo relative microblog in the main.php.
	public static function echo_weibobrief($item){
		$wbnum = 3;
		$fui = Tool::get_fui($_SESSION['uid']);		
		$sql = "SELECT mid,uid,sn,murl,mc,pt FROM `weibomsg` WHERE uid IN ({$fui}) AND mid IN (SELECT mid FROM `abbre_weibomsg`"
		        . " WHERE abrid=" . $item['abrid'] . ") GROUP BY mid ORDER BY pt DESC LIMIT $wbnum";
		$result = Conn::select($sql);
		if(mysql_num_rows($result) > 0) {
			$row = mysql_fetch_array($result);
			$str = '<div class="weibo_tittle_sep"><div class="weibo_tittle_sep_line"></div></div>';
			$str = $str.Tool::_handle_wbmsg($row,$item['kl']);
			while($row = mysql_fetch_array($result)){
				$str = $str.'<div class="weibo_sep"><div class="weibo_sep_line"></div></div>'.Tool::_handle_wbmsg($row,$item['kl']);
			}
			echo($str);
		}
		Conn::close();
	}

	//Echo the navigation url on the right.
	public static function echo_rnavigurl($rpage,$flag,$param,$targetpage){
		$url = $targetpage;
		if(!empty($rpage) && $rpage > 0){
			if($flag == 1) {
				if($rpage > 1)
					$rpage--;
			} else {
				$rpage++;
			}
		} else {
			$rpage = 1;
		}
		$url = $url."rpage=$rpage";
		if(!empty($param)){
			$url .= '&&'.$param;
		}
		echo($url);
	}

	//Echo the navigation on the right.
	public static function echo_rnavig($rpage,$num,$condition){
		$sql = "SELECT abrid,kl FROM `abbreviation` ";
		if(!empty($condition) && $condition != "") {
			$sql = $sql."WHERE $condition";
		}
		$sql = $sql." ORDER BY mt,pt,abrid DESC LIMIT ".($rpage-1)*$num.",$num";
		$result = Conn::select($sql);
		$str = "";
		if(mysql_num_rows($result)){
			$str = "<ul class='voc'>";
			while($row = mysql_fetch_array($result)){
				$str = $str."<li><a href='detail.php?abbre={$row['abrid']}' onclick='goto('voc1')'>";
				$str = $str."{$row['kl']}</a><a href='detail.php?abbre={$row['abrid']}' class='detail'>[详细]</a></li>";
			}
			$str .= "</ul>";
		}
		echo($str);
		Conn::close();
	}

	//echo a microblog in detail.php.
	public static function echo_wbmsg($row,$kl){
		$str = str_replace($kl,"<font color='#FF0000'>".$kl."</font>",$row['mc']);
		if(!empty($row['murl'])){
			$str = $str."&nbsp;详见：<a href='{$row['murl']}' target='_blank'><font color='#0082D1'>".$row['murl']."</font></a>";
		}
		echo($str);
	}
	
	//echo relative resource in detail.php
	public static function echo_relateresource($abrid,$size){
		$sql = "SELECT * FROM `outsource` WHERE osid IN (SELECT osid FROM `abbre_outs` WHERE abrid=$abrid) ORDER BY osid DESC LIMIT $size";
		$result = Conn::select($sql);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			$str = '<div class="relate_resource"><span class="relate_resource_title">相关资源：</span><span class="relate_resource_content">';
			$str .= "<a href={$row['url']} target='_blank'>{$row['tl']}</a>";
			while($row = mysql_fetch_array($result)) {
				$str = $str."<span class='split_font'> | </span>";
				$str = $str."<a href={$row['url']} target='_blank'>{$row['tl']}</a>";
			}
			$str .= '</span></div>';
			echo($str);
		}
		Conn::close();
	}

	public static function get_avoid_noneset($row,$key,$default=Null){
		$value = $default;
		if(array_key_exists($key, $row)){
			$value = $row[$key];
		}
		return $value;
	}

	public static function get_user_info($uid){
		$sql = "SELECT sn,sx,vi,dr,bl,de,ad,un,an,fn,mn,ci,ei,iu,iv,tg,rn,bd,qq,msn,email,at,ti
				FROM `userlist` WHERE uid={$uid} LIMIT 1";
		$result = Conn::select($sql);
		$uinfo = Null;
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_object($result);
			$uinfo = $row;
		}
		Conn::close();
		return $uinfo;
	}
}
?>
