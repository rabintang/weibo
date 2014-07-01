<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A Rewrite Version Of Loader Class
 *
 * Loads views and files
 *
 * @author Tbin <tbinhit@foxmail.com>
 */

class Hit_Loader extends CI_Loader 
{
	public function __construct() 
	{
		parent::__construct();
	}

	/**
	 * Model Loader
	 *
	 * 重写Load model 方法，使其能够向构造函数传递参数
	 *
	 * @param	string	the name of the class
	 * @param 	array 	$params 传递给模型的参数
	 * @param	string	name for the model
	 * @param	bool	database connection
	 * @return	void
	 */ 
	public function model($model, $params = NULL, $name = '', $db_conn = FALSE) 
	{
		if (is_array($model)){
			foreach ($model as $babe){
				$this->model($babe, $params);
			}
			return;
		}
		if ($model == ''){
			return;
		}
		$path = '';
		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)	{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);
			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}
		if ($name == ''){
			$name = $model;
		}
		if (in_array($name, $this->_ci_models, TRUE)){
			return;
		}
		$CI =& get_instance();
		if (isset($CI->$name)){
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}
		//$model = strtolower($model);
		foreach ($this->_ci_model_paths as $mod_path){
			if ( ! file_exists($mod_path.'models/'.$path.$model.'.php')){
				continue;
			}
			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))	{
				if ($db_conn === TRUE){
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}
			if ( ! class_exists('CI_Model')) {
				load_class('Model', 'core');
			}
			require_once($mod_path.'models/'.$path.$model.'.php');
			$model = ucfirst($model);

			if ( ! is_null($params) && ! is_array($params)) {
				$params = NULL;
			}

			$CI->$name = new $model($params);
			$this->_ci_models[] = $name;
			return;
		}
		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}

	/**
	 * Prep filename 取消了 helper 对文件名小写的要求
	 *
	 * This function preps the name of various items to make loading them more reliable.
	 *
	 * @param	mixed
	 * @param 	string
	 * @return	array
	 */
	protected function _ci_prep_filename($filename, $extension)
	{
		if ( ! is_array($filename)) {
			return array(str_replace('.php', '', str_replace($extension, '', $filename)).$extension);
		} else {
			foreach ($filename as $key => $val) {
				$filename[$key] = str_replace('.php', '', str_replace($extension, '', $val)).$extension;
			}
			return $filename;
		}
	}

	/**
	 * 对 view 函数的扩展,使其自动加载 head 和 foot,只需要在加载页中通过调用 head/foot 字段即可
	 * @param  string  $view   中间模块的试图文件名
	 * @param  array   $vars   传入试图中的参数
	 * @param  boolean $return 是返回字符串还是直接加载它
	 * @return string          生成的网页字符串
	 */
	public function auto_view($view, $vars = array(), $return = FALSE)
	{
		$CI = & get_instance();
		$CI->load->model('Hit_CategoryModel','category');
		$ary_categories = $CI->Hit_CategoryModel->select(array('fields' => 'categoryid, name'));
		$vars['head'] = $CI->load->view('modules/head', array('categories'=>$ary_categories), TRUE);
		$vars['foot'] = $CI->load->view('modules/foot', NULL, TRUE);
		return $CI->load->view($view, $vars, $return);
	}
}