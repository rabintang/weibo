<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'saetv2.ex.class.php';

/**
 * 新浪微博 助手
 *
 * 封装了新浪微博 SaeTClientV2 类 
 *
 * @package 
 * @author Tang Bin
 * @version 1.0
 */
class Hit_SaeTClient extends SaeTClientV2{
	private static $config; // 保存配置文件中的配置信息，主要是keys和callback_url

	/**
	 * 初始化静态成员变量config
	 */
	public static function init_config(){
		$ci = & get_instance();
		$ci->load->config('hit_config',true);
		self::$config = $ci->config->item('weibo');
	}

	function __construct($params){
		define( 'DEBUG_MODE', false );
		if ( !function_exists('curl_init') ) {
		    echo '您的服务器不支持 PHP 的 Curl 模块，请安装或与服务器管理员联系。';
		    exit;
		}
		if ( DEBUG_MODE ) {
		    error_reporting(E_ALL);
		    ini_set('display_errors', true);
		}

		parent::__construct(self::$config['wb_akey'], self::$config['wb_skey'], $params['access_token']);
	}
}
Hit_SaeTClient::init_config();
?>