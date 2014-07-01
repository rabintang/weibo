<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 定义程序用到的变量值
 */

/**
 * 微博验证的一些相关变量
 */

$config['SINA_AKEY'] = '3659663781';
$config['SINA_SKEY'] = 'a8d31662bd7c3b73bc10bd20da18e782';
$config['SINA_CALLBACK_URL'] = 'http://weibo.haitianyuan.com/index.php/callback';

/**
 * right box 的一些配置信息
 */
// 右侧缩略导航栏每页展示词条数
$config['RIGHT_HAND_ENTRY_PAGESIZE'] = 13;


/**
 * 推荐信息的一些配置
 */
// 用户初始登录系统时，推荐用的获取用户好友状态的最大条数
$config['max_status_count_login_recommend'] = 800;
// 用户每次登录,系统推荐词条的最大条数
$config['TOPN'] = 5;
// main页词条展示的相关微博,限制的好友微博发布多少天之内的微博
$config['FRIEND_BLOG_PUBLISHTIME_LIMIT'] = 0;
// main页词条展示的相关微博,限制的微博发布多少天之内的微博
$config['GLOBAL_BLOG_PUBLISHTIME_LIMIT'] = 0;


/**
 * main 页词条/微博展示相关参数
 */
// main 页每条词条最多展示的微博数量
$config['MAIN_CORRELATE_BLOGS_COUNT'] = 3;
// main 页每条词条最多展示的相关博主数量
$config['MAIN_CORRELATE_BLOGGERS_COUNT'] = 5;
// main 页词条最多展示的相关词条数量
$config['MAIN_CORRELATE_ENTRY_COUNT'] = 3;
// main页,每页展示的词条数
$config['MAIN_ENTRY_PAGESIZE'] = 10;
// main页词条摘要的截断长度
$config['MAIN_ENTRY_SUMMARY_LENGTH'] = 360;
// main页词条相关微博一条记录的总长度
$config['MAIN_CORRELATE_BLOG_LENGTH'] = 104;

/**
 * detail 页词条/微博显示相关参数
 */
// detail 页相关资源展示数量
$config['DETAIL_CORRELATE_RESOURCE_COUNT'] = 3;
// detail 页每条词条最多展示的相关博主数量
$config['DETAIL_CORRELATE_BLOGGERS_COUNT'] = 5;
// detail 页词条最多展示的相关词条数量
$config['DETAIL_CORRELATE_ENTRY_COUNT'] = 3;
// detail页,每页展示的微博数
$config['DETAIL_BLOG_PAGESIZE'] = 10;

/**
 * search 页相关设置
 */
$config['SEARCH_ENTRY_PAGESIZE'] = 10;
