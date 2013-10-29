<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 保存新浪微博API中定义一些常量
 */

// 每次请求新浪微博API返回关注列表ID最大值	
define('MAX_FRIENDSHIP_FRIENDS_IDS_COUNT',5000);

// 每次请求新浪微博API返回的用户及好友最新微博的条数
define('MAX_STATUSES_FRIENDS_TIMELINE_COUNT',100);