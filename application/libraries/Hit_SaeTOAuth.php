<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'saetv2.ex.class.php';

/**
 * 对SaeTOAuthV2的封装
 */
class Hit_SaeTOAuth extends SaeTOAuthV2{
	private $akey;
	private $skey;
	private $callbakc_url;
	
	/**
	 * 自定义授权类的构造函数
	 */
	function __construct($config_file = 'hit_config'){
		define( 'DEBUG_MODE', false );
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
				
		$ary_config = get_config_value(array('wb_akey', 'wb_skey', 'wb_callback_url'));
		$this->akey = $ary_config['wb_akey'];
		$this->skey = $ary_config['wb_skey'];
		$this->callback_url = $ary_config['wb_callback_url'];
		
		parent::__construct($this->akey, $this->skey);
	}

	/**
	 * 获取授权URL
	 * @param  string $response_type 支持的值包括 code 和token 默认值为code
	 * @param  string $state 用于保持请求和回调的状态。在回调时,会在Query Parameter中回传该参数
	 * @param  string $display 授权页面类型 可选范围:
	 *  - default		默认授权页面
	 *  - mobile		支持html5的手机
	 *  - wap1.2		wap1.2页面
	 *  - wap2.0		wap2.0页面
	 *  - apponweibo	站内应用专用,站内应用不传display参数,并且response_type为token时,默认使用改display.授权后不会返回access_token，只是输出js刷新站内应用父框架
	 * @param  bool $forcelogin 是否强制用户重新登录，true：是，false：否。默认false
	 * @param  string $language 授权页语言，缺省为中文简体版，en为英文版。英文版测试中，开发者任何意见可反馈至 @微博API
	 * @return string
	 */
	public function get_authorize_url($response_type = 'code', $state = NULL, $display = NULL, $forcelogin = NULL, $language = NULL){
//		echo 'ssss' .  self::$config['wb_callback_url'];
//		echo 'fffff'. self::$config['wb_akey'];
		return $this->getAuthorizeURL($this->callback_url, $response_type, $state, $display, $forcelogin, $language);
	}

	/**
	 * 获取回调地址
	 * @return string
	 */
	public function get_callback_url(){
		return $this->callback_url;
	}

	/**
	 * 获取access_token
	 * @param  string $type 请求的类型,可以为:code, password, token
	 * @param  array $keys 其他参数：
	 *  - 当$type为code时： array('code'=>..., 'redirect_uri'=>...)
	 *  - 当$type为password时： array('username'=>..., 'password'=>...)
	 *  - 当$type为token时： array('refresh_token'=>...)
	 * @return string
	 */
	public function get_access_token($type = 'code', $keys){
		return $this->getAccessToken($type, $keys);
	}
}
?>
