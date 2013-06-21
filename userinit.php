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
//$ms  = $c->home_timeline(); // Get user and his attensions' newest microblogs.
?>
