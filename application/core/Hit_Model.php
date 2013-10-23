<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hit_Model extends CI_Model 
{
	protected $table_name;

	function __construct($table_name = NULL)
	{
		parent::__construct();

		$this->table_name = $table_name;
		$this->load->database();
	}

	/**
	 * 更新一条数据
	 * @param  array $instance 待更新的数据
	 * @param  array/string $conditions 查询条件。键为左值，值为右值/查询的where子句
	 * @return int/bool 更新成功返回受影响的行数，否则返回false
	 */
	public function update($instance, $conditions) 
	{
		try{
			$this->db->where($conditions);
			$this->db->update($this->table_name, $instance);
			return $this->db->affected_rows();
		} catch(Exception $e) {
			log_message('error', 'In update ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * 批量更新数据，同官方的相应方法。
	 * 见http://ellislab.com/codeigniter/user-guide/database/active_record.html#update
	 * @param  array $instances 包含待更新数据集的数组
	 * @param  string $condition_field 条件域
	 * @return int/bool 更新成功返回受影响的行数，否则返回false
	 */
	public function update_batch($instances, $condition_field)
	{
		try{
			$this->db->update_batch($this->table_name, $instances, $condition_field);
			return $this->db->affected_rows();
		} catch(Exception $e) {
			log_message('error', 'In batch update ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * 插入一条数据
	 * @param  array $instance 包含待插入数据的关联数组
	 * @return int/bool 插入成功返回受影响的行数，否则返回false
	 */
	public function insert($instance) 
	{
		try{
			$this->db->insert($this->table_name, $instance);
			return $this->db->affected_rows();
		} catch(Exception $e) {
			log_message('error', 'In insert ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
		return FALSE;
	}

	/**
	 * 插入一组数据
	 * @param  array $instances 待插入数据集的数组
	 * @return int/bool 插入成功返回受影响的行数，否则返回false
	 */
	public function insert_batch($instances)
	{
		try{
			$this->db->insert_batch($this->table_name, $instances);
			return $this->db->affected_rows();
		} catch(Exception $e) {
			log_message('error', 'In batch insert ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
		return FALSE;
	}


	/**
	 * 获取查询数据
	 * @param array $params 查询条件,其中包含的字段如下:
	 * 		string 			$return_type 查询结果返回的数据格式。array：以关联数组形式返回结果；object：以对象形式返回
	 *   	string/array 	$fields 待查询的域
	 *    	string/array 	$conditions where子句
	 *    	array           $like like子句
	 *    						likes array like子句的键值对,键为字段名,值为字段值匹配的字符串
	 *    						type string %的方式,'before'/'after'/'none'/'both'(默认值)
	 *    	array           $subselect 子查询
	 *     	string 			$groupby 分组域
	 *      string/array 	$orderby 排序方式。如果为关联数组，则键为字段名，值为排序方式
	 *      integer/array 	$limit 获取的记录限制。如果为关联数组，第一个值为since，第二值为count；若为整型，则为返回记录条数
	 * @param bool $escape 是否给字段或表明加反引号
	 * @return array/objects 查询结果，查询失败返回false
	 */
	public function select($params = array(), $escape = TRUE)
	{
		try{
			// 处理待查询字段
			if(isset($params['fields'])){
				if($this->string_condition($params['fields'])) {
					$this->db->select($params['fields'], $escape);
				} else if($this->array_condition($params['fields'])) {
					$str_fields = implode(',', $params['fields']);
					$this->db->select($params['fields'], $escape);
				}
			}

			// 处理like子句
			if(isset($params['like'])){
				if($params['like']['type'] == 'both'){
					$this->db->like($params['like']['likes']);
				} else {
					foreach($params['like']['likes'] as $key=>$value){
						$this->db->like($key, $value, $params['like']['type']);
					}
				}
			}

			// 处理查询条件，即where子句
			if(isset($params['conditions'])){
				$this->db->where($params['conditions'], NULL, $escape);
			}
			if(isset($params['subselect'])){
				foreach($params['subselect'] as $key=>$value){
					$this->db->where_in($key, $value, $escape);
				}
			}

			if(isset($params['groupby'])){
				$this->db->group_by($params['groupby']);
			}

			// 处理排序
			if(isset($params['orderby'])){
				if($this->array_condition($params['orderby'])){
					foreach($params['orderby'] as $field=>$method) {
						$this->db->order_by($field, $method);
					}
				} else if($this->string_condition($params['orderby'])){
					$this->db->order_by($params['orderby']);
				}
			}
			
			// 处理返回记录条数，limit子句
			if(isset($params['limit'])){
				if($this->integer_condition($params['limit'])){
					if($params['limit'] > 0){
						$this->db->limit($params['limit']);
					}
				} else if($this->array_condition($params['limit'])) {
					if(sizeof($params['limit']) >= 2){
						$this->db->limit($params['limit'][1], $params['limit'][0]);
					} else {
						$this->db->limit($params['limit'][0]);
					}
				}
			}

			$query = $this->db->get($this->table_name);

			// 返回查询结果
			if(isset($params['return_type']) && $params['return_type'] == 'object') { // 以object形式返回结果				
				return $query->result();
			} else { // 以array形式返回结果
				return $query->result_array();
			}
		} catch(Exception $e) {
			log_message('error', 'In select ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
	}


	/**
	 * 获取表的数据行数
	 * @param  array $params 查询条件
	 *                       conditions 查询条件
	 *    	   array         like like子句
	 *    						likes array like子句的键值对,键为字段名,值为字段值匹配的字符串
	 *    						type string %的方式,'before'/'after'/'none'/'both'(默认值)
	 *                       subselect 子查询
	 * @param  bool $escape 是否给字段或表明加反引号
	 * @return integer             行数,查询失败返回false
	 */
	public function get_rows_num($params = array(), $escape = TRUE)
	{
		try{
			if(isset($params['conditions'])){
				$this->db->where($params['conditions'], NULL, $escape);
			}

			// 处理like子句
			if(isset($params['like'])){
				if($params['like']['type'] == 'both'){
					$this->db->like($params['like']['likes']);
				} else {
					foreach($params['like']['likes'] as $key=>$value){
						$this->db->like($key, $value, $params['like']['type']);
					}
				}
			}

			if(isset($params['subselect'])){
				foreach($params['subselect'] as $key=>$value){
					$this->db->where_in($key, $value, $escape);
				}
			}
			$this->db->from($this->table_name);
			return $this->db->count_all_results();
		} catch(Exception $e) {
			log_message('error', 'In get total rows of ' . $this->table_name . ': ' . $e->getMessage());
			return FALSE;
		}
	}


	/*返回最新执行的一条SQL语句*/
	public function get_last_query()
	{
		return $this->db->last_query();
	}

	/**
	 * 判断是否为string类型的条件
	 * @param  [type] $condition 待判断的条件
	 * @return bool 是返回true，否则返回false
	 */
	protected function string_condition($condition)
	{
		if($condition && is_string($condition) && trim($condition) != '') {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 判断是否为array类型的条件
	 * @param  [type] $condition 待判断的条件
	 * @return bool 是返回true，否则返回false
	 */
	protected function array_condition($condition)
	{
		if($condition && is_array($condition) && sizeof($condition) > 0) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 判断是否为integer类型的条件
	 * @param  [type] $condition 待判断的条件
	 * @return bool 是返回true，否则返回false
	 */
	protected function integer_condition($condition)
	{
		if($condition && is_integer($condition)) {
			return TRUE;
		}
		return FALSE;
	}
}
