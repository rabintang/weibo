<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'saetv2.ex.class.php';

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
	private $akey;
	private $skey;
	
	function __construct($params){
		if( ! defined('DEBUG_MODE')) {
			define( 'DEBUG_MODE', false );
		}
		if ( !function_exists('curl_init') ) {
		    echo '您的服务器不支持 PHP 的 Curl 模块，请安装或与服务器管理员联系。';
		    exit;
		}
		if ( DEBUG_MODE ) {
		    error_reporting(E_ALL);
		    ini_set('display_errors', true);
		}
		
		$CI = & get_instance();
		$CI->load->helper('Hit_config');
		$ary_config = get_config_value(array('wb_akey', 'wb_skey'));
		$this->akey = $ary_config['wb_akey'];
		$this->skey = $ary_config['wb_skey'];
		
		parent::__construct($this->akey, $this->skey, $params['access_token']);
	}
}
?>
