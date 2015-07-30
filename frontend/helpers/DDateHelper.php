<?php
namespace frontend\helpers;


class DDateHelper
{
    public static function DateToUnix($date_str, $type = 1)
    { 
		$date_str_arr = explode('-', $date_str);
		switch($type) {
			case 1: //2015-07-13
				$date = mktime(00, 00, 00, $date_str_arr[1], $date_str_arr[2], $date_str_arr[0]);
				break;
			
			case 2: //13-07-2015
				$date = mktime(00, 00, 00, $date_str_arr[1], $date_str_arr[0], $date_str_arr[2]);
				break;
			
		}
		return $date;
    }
}

