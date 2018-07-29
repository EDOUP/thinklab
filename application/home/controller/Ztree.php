<?php
	namespace app\home\Controller;

	use app\index\controller\Common;
	use app\home\model\Nodes;
	use think\Db;

	class Ztree extends Common{
		//设置警报时间 未完成
		public function addAlarmTime(){
			$user = session('user');
			$OwnerId = $user['id'];
		 	//$list =Db::connect('db_config3')->query("select * from nodes where  OwnerId = {$OwnerId} OR xlh is null");
		 	$list =Db::connect('db_config3')->query("select * from nodes where  OwnerId = {$OwnerId}");
		 	//print_r($list);
		 	$result =array();
		 	$length = count($list);
		 	for($i = 0; $i<$length; $i++){
		 		$pId = $list[$i]['pId'];
		 		while($pId != 0){
		 			$data =Db::connect('db_config3')->query("select * from nodes where id = {$pId}");
		 			$result[] = $data[0];
		 			$pId = $data[0]['pId'];
		 		}
		 	}
		 	if($length == 1){
		 		return $result;
		 	}else{
		 		$datas = array();
			 	for($i=0; $i<count($result);$i++){
			 		$flag = 0;
			 		for($j=0;$j<count($datas);$j++){
			 			if($result[$i]['name'] == $datas[$j]['name']){
			 				$flag = 1;
			 				break;
			 			}
			 		}

			 		if($flag == 0){
			 			$datas[] = $result[$i];
			 		}
			 	}
		 	}
		 	
		 	

		}
		//节点初始化
		public function init(){

			 $user = session('user');

			 if($user['authority'] == 0 || $user['authority'] == 1){
			 	$list =Db::connect('db_config3')->table('nodes')->select();

			 	return json($list);
			 }else{
			 	$OwnerId = $user['id'];
			 	//$list =Db::connect('db_config3')->query("select * from nodes where  OwnerId = {$OwnerId} OR xlh is null");
			 	$list =Db::connect('db_config3')->query("select * from nodes where  OwnerId = {$OwnerId}");
			 	$result =array();
			 	$length = count($list);
			 	for($i = 0; $i<$length; $i++){
			 		$pId = $list[$i]['pId'];
			 		while($pId != 0){
			 			$data =Db::connect('db_config3')->query("select * from nodes where id = {$pId}");
			 			$result[] = $data[0];
			 			$pId = $data[0]['pId'];
			 		}
			 	}
			 	if($length == 1){
			 		return $result;
			 	}else{
			 		$datas = array();
				 	for($i=0; $i<count($result);$i++){
				 		$flag = 0;
				 		for($j=0;$j<count($datas);$j++){
				 			if($result[$i]['name'] == $datas[$j]['name']){
				 				$flag = 1;
				 				break;
				 			}
				 		}

				 		if($flag == 0){
				 			$datas[] = $result[$i];
				 		}
				 	}
				 	for($i=0; $i<count($list);$i++){
				 		$datas[] = $list[$i];
				 	}
				 	return json($datas);
			 	}

			 	
			 }

		}
		
		//查找最新节点
		public function lastdata(){
			$sqlname = $this->request->param('sqlname');
			$result =Db::connect('db_config3')->query("select * from {$sqlname} where nodeid=(select max(nodeid) from {$sqlname})");
			//$result =Db::connect('db_config3')->query('select * from nodes');
			//PRINT_R($result);
			//$this->assign($result);
			//var_dump($result);
			return json($result);
		}
		//统计图功能 完成  日期写死了
		public function columndata(){
			$nodenum = $this->request->param('nodename');
			//当月日期
			//$mydate = date("Y-m");
			//假定当前日期为2017-10
			$testdate = '2017-10';
			// state 1表示数据重复 2表示数据异常 把两个数据都查出来封装起来给前端
			$result1 =Db::connect('db_config3')->query("select count(*) from equip_alarm where state=1 and node={$nodenum} and time like '%{$testdate}%'");
			$result2 =Db::connect('db_config3')->query("select count(*) from equip_alarm where state=2 and node={$nodenum} and time like '%{$testdate}%'");
			//将上面两个查询结果重新组合
			$getRepeat = $result1[0]['count(*)'];
			$getEror = $result2[0]['count(*)'];
			$newResult = array($getRepeat,$getEror);
			//创建新的数组 包含日期(写死了)及$newResult
			$arr = array('arr' => $testdate, 'data' => $newResult);
			//print_r($arr);
			return json($arr);
		}

		//折线图功能 查找当前时间前十二个小时的节点数据 日期写死了
		public function linedata(){
			$nodename = $this->request->param('nodename');
			//当前年月日
			//$mydate = date("Y-m-d");
			//假定时间为2017-10-09
			$testdate = "2017-10-09";
			//获取当前小时
			$curhour = date("H");
			//print_r($curhour);
			//将当前时间的前12个小时数据放入数组
			$hours = array();
			if($curhour > 11){
				for($i=0; $i<12; $i++){
					$newhour = $curhour+$i-11;
					if($newhour < 10){
						$hours[$i] = '0'.$newhour;
					}else{
						$hours[$i] = $newhour;
					}
				}
			}else{
				for($i=0; $i<12; $i++){
					$newhour = $curhour+$i-11;
					if($newhour<0){
						$hours[$i] = $newhour+24;
					}else{
						if($newhour>= 10){
							$hours[$i] = $newhour;
						}else{
							$hours[$i] = '0'.$newhour;
						}
					}
				}
			}
			//print_r($hours);

			$data = array();
			$index = 0;
			while($index<count($hours)){
				$result =Db::connect('db_config3')->query("SELECT * FROM {$nodename} where time like BINARY'%{$testdate} ${hours[$index]}%' LIMIT 1");
				$data[$index] = $result[0];
				$index++;
			}

			//将hours 和 data传给页面
			$datas = array('arr' => $hours, 'data' => $data);
			//print_r($datas);
			return json($datas);
		}
	}