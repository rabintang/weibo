<?php
//$conn;
define("servername","localhost");
define("username","root");
define("password","tangbin//");
define("database","weiboapp");
class Conn {
	public static function connect() {
	    	if(!isset($GLOBALS['conn']) || $GLOBALS['conn'] == NULL || !is_resource($GLOBALS['conn'])) {
    			$GLOBALS['conn'] = @mysql_connect(servername,username,password);
    			if(!$GLOBALS['conn']) {
    				die('Counld not connect: ' . mysql_error());
    			}
    			mysql_query("SET NAMES 'UTF8'"); //解决中文乱码问题
    		}
	}

	public static function close() {
		if (isset($GLOBALS['conn']) && is_resource($GLOBALS['conn'])) {
		    mysql_close($GLOBALS['conn']);
		}
		if(isset($GLOBALS['conn']) && is_resource($GLOBALS['conn']))
		    echo(failed);
	}

	public static function select($sql) {
	    	Conn::connect();  
		mysql_select_db(database,$GLOBALS['conn']);
		$result = mysql_query($sql);
		return $result;
	}

	public static function execute($sql) {
		Conn::connect();
		mysql_select_db(database,$GLOBALS['conn']);
		mysql_query($sql);
		$row_num = mysql_affected_rows($GLOBALS['conn']);
		Conn::close();
		return $row_num;
	}
}
?>
