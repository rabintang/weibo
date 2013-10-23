<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * 获取当前时间下加一个时间间隔的时间
 * 	$interval array/int 若为数组,通过year/month/day/hour/minute/second指定各数值
 *			若为int,则为day
 */
if( ! function_exists('add_interval') )
{
	function add_interval($interval = NULL)
	{
		$second = date('s');
		$minute = date('i');
		$hour = date('H');
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		if(is_array($interval)){
			if(isset($interval['second'])){
				$second += $interval['second'];
			}
			if(isset($interval['minute'])){
				$minute += $interval['minute'];
			}
			if(isset($interval['hour'])){
				$hour += $interval['hour'];
			}
			if(isset($interval['day'])){
				$day += $interval['day'];
			}
			if(isset($interval['month'])){
				$month += $interval['month'];
			}
			if(isset($interval['year'])){
				$year += $interval['year'];
			}
			return date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year));
		} else if(is_integer($interval)){
			$day = $day + $interval;
			return date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year));
		} else {
			return date('Y-m-d H:i:s', time());	
		}		
	}
}
