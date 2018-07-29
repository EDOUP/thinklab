<?php
	namespace app\home\commond;

	class LabUtil{
		/**
		*  输入两个日期 找到两个日期之间的所有日期
		*/
		public static function findDateRange($start, $end){
			$dt_start = strtotime($start);
		    $dt_end = strtotime($end);
		    $arr = array();
		    $index = 0;
		    while ($dt_start<=$dt_end){
		        echo date('Y-m-d',$dt_start)."\n";
		        $arr[$index] = $dt_start;
		        $dt_start = strtotime('+1 day',$dt_start);

		        $index++;
		    }
		    return $arr;
		}
	}