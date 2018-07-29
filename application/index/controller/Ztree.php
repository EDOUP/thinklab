<?php
	namespace app\index\controller;

	use app\index\controller\Common;
	use app\index\model\Nodes;
	use think\Db;

	class Ztree extends Common{

		public function init(){
			$nodes = new Nodes();
			$list =  $nodes->select();
			return json($list);
		}
		
		//查找最新节点
		public function lastdata(){
			$sqlname = $this->request->param('sqlname');
			$result = Db::Connect('db_config1')->query("select * from {$sqlname} where nodeid=(select max(nodeid) from {$sqlname})");
			//$result = Db::query('select * from nodes');
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
			$result1 = Db::Connect('db_config1')->query("select count(*) from equip_alarm where state=1 and node={$nodenum} and time like '%{$testdate}%'");
			$result2 =  Db::Connect('db_config1')->query("select count(*) from equip_alarm where state=2 and node={$nodenum} and time like '%{$testdate}%'");
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
				$result =  Db::Connect('db_config1')->query("SELECT * FROM {$nodename} where time like BINARY'%{$testdate} ${hours[$index]}%' LIMIT 1");
				$data[$index] = $result[0];
				$index++;
			}

			//将hours 和 data传给页面
			$datas = array('arr' => $hours, 'data' => $data);
			//print_r($datas);
			return json($datas);
		}
	}