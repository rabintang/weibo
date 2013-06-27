<?php
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
include('includes/conn.php');

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$c->set_debug( DEBUG_MODE );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$_SESSION['uid'] = $uid;

$user = $c->show_user_by_id($uid); // Get user's details

/*********** 更新用户的个人信息 ************/
// Generate user's friendships string
$str_frdids = '';
$next_cursor = 0;
do {
	$frdids = $c->friends_ids_by_id($uid,$next_cursor,5000);
	if($frdids['total_number'] > 0){
		if($str_frdids != '')
	      		$str_frdids .= ",'";
		else
			$str_frdids .= "'";
		$str_frdids .= implode("','",$frdids['ids']);
		$str_frdids .= "'";
	} else {
		break;
	}
	$next_cursor = $frdids['next_cursor'];
} while($frdids['total_number'] == 5000);
$sql = "SELECT uid FROM `userlist` WHERE uid='" . $uid . "'";
$is_new = Conn::select($sql);
$now = date('Y-m-d H:i:s');
$address = (string)$user['province'] . ' ' . (string)$user['city'];
$iv = $user['verified']?1:0;
if(mysql_num_rows($is_new) > 0){ // This user is an old user. Then update user's information
	$sql = "UPDATE `userlist` SET
				sn='{$user['screen_name']}',
				sx='{$user['gender']}',
				vi='{$user['verified_reason']}',
				de='{$user['description']}',
				ad='$address',
				bl='{$user['url']}',
				un='{$user['name']}',
				an={$user['friends_count']},
				fn={$user['followers_count']},
				mn={$user['statuses_count']},
				iu='{$user['profile_image_url']}',
				iv={$iv},
				at='{$user['created_at']}',
				ti='{$now}',
				fui=\"{$str_frdids}\"
			WHERE uid='{$uid}'";
} else { // Insert user's information
	$sql = "INSERT INTO `userlist` (uid,sn,sx,vi,de,ad,bl,un,an,fn,mn,iu,iv,at,ti,fui) 
		VALUES ('{$user['id']}','{$user['screen_name']}','{$user['gender']}','{$user['verified_reason']}',
		        '{$user['description']}','$address','{$user['url']}','{$user['name']}',
		        {$user['friends_count']},{$user['followers_count']},{$user['statuses_count']},
		        '{$user['profile_image_url']}',{$iv},'{$user['created_at']}',
		        '{$now}',\"{$str_frdids}\")";
}
Conn::execute($sql);

/*********** 实时获取用户的最新微博 ************/
$sql = "SELECT abrid,kl FROM `abbreviation`";
$result = Conn::select($sql);
$abbre_list = array();
while($row = mysql_fetch_array($result)) {
	$abbre_list[$row['kl']] = $row['abrid'];
}
Conn::close();

define('MAX_WEIBO_COUNT',400); // The max value to fetch the user's newest microblog.
define('MAX_WEIBO_PER_REQUEST',100);  // max value of microblog of each request.
$sql_weibomsg = "INSERT INTO `weibomsg` (mid,uid,un,sn,iu,rmid,mc,murl,srn,iurl,aurl,vurl,rc,cc,pt,nc) VALUES ";
$sql_mapping = "INSERT INTO `abbre_weibomsg` (abrid,mid) VALUES ";
$now = date("Y-m-d H:i:s");
$sql_abbre = "UPDATE `abbreviation` SET mt='{$now}' WHERE abrid in (";
$str_weibomsg = ''; // SQL used to insert into table - weibomsg.
$str_mapping = ''; // SQL used to insert into table - abbre_weibomsg.
$abrid_list = array(); // Abrid array used to modify mt value of table - abbreviation.
for($i = 1; $i <= MAX_WEIBO_COUNT/MAX_WEIBO_PER_REQUEST; $i++) {
	$mslist = $c->home_timeline($i);
	for($j = 0; $j < sizeof($mslist['statuses']); $j++){
		$status = $mslist['statuses'][$j];
		$status_text = $status['text'];
		while(isset($status['retweeted_status'])){ // To handle the retweeted status.
			$status = $status['retweeted_status'];
			if(isset($status['user'])){ // If the status is not deleted by the owner.
				$status_text .= '//@' . $status['user']['screen_name'] . $status['text'];
			}
		}
		$status = $mslist['statuses'][$j];
		$status_flag = false; // To identify whether the status has inserted in the database.
		foreach($abbre_list as $key=>$abrid){ // To find the abbreviation in each status.
			if(stripos($status_text,$key)){ // Have found the abbreviation.
				if(!$status_flag) { // Construct SQL of weibomsg.
					$status_flag = true;
					$user = $status['user'];
					$publish_time = date('Y-m-d H:i:s',strtotime($status['created_at']));
					$retweeted_id = isset($status['retweeted_status'])?$status['retweeted_status']['mid']:'NULL';
					$str_weibomsg .= "('{$status['mid']}','{$user['id']}','{$user['name']}','{$user['screen_name']}',
						'{$user['profile_image_url']}','{$retweeted_id}','{$status_text}',NULL,'{$status['source']}',
						NULL,NULL,NULL,{$status['comments_count']},{$status['reposts_count']},'{$publish_time}',
						NULL),";
				}
				$str_mapping .= "({$abrid},'{$status['mid']}'),";
				$abrid_list[$abrid] = 1;
			}
		}
	}
	if($mslist['total_number'] <= $i * MAX_WEIBO_PER_REQUEST)
	      break;
}
if($str_weibomsg != ''){
	$str_weibomsg = rtrim($str_weibomsg,',');
	$str_mapping = rtrim($str_mapping,',');
	$str_abbre = implode(',',array_keys($abrid_list));
	$sql_weibomsg .= $str_weibomsg;
	$sql_abbre .= $str_abbre . ')';
	$sql_mapping .= $str_mapping;
	Conn::execute($sql_weibomsg);
	Conn::execute($sql_abbre);
	Conn::execute($sql_mapping);
	Conn::close();
}
?>
