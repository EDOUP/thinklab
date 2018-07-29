<?php

	namespace app\home\controller;

	use app\index\controller\Common;
	use app\home\model\Nodes;
	use think\Db;
	/**
	*	导航条的查询功能 主要是历史查询
	*/
	class Nav extends Common{
		
		//删除节点功能
		public function deleteMenuDatas(){
			$data = $this->request->post();
			$id = $data['id'];
			$result = db('nodes','db_config3')->where('id',$id)->delete();
			return $result;
		}

		//添加节点功能
		public function addMenuDatas(){
			$data = $this->request->post();
						
		    db('nodes','db_config3')->insert($data);
		   
		}

		//添加设备，设置健康状况为1
		public function addEquitment(){

			$data = $this->request->post();
			
			db('nodes','db_config3')->insert($data);

			

		}


		//修改节点
		public function editMenuDatas(){			
			
     		$data = $this->request->post();
			$treeNodeId = $data['treeNodeId'];
			$newName = $data['newName'];
			//Db::execute("UPDATE nodes SET name= {$newName} WHERE id= {$treeNodeId}");
			$result = db('nodes','db_config3')->where('id',$treeNodeId)->data(['name'=>$newName])->update();
			

		}

		//查询历史记录
		public function findHis(){
			$xlh = $this->request->param('Xlh');
			$dateFrom = $this->request->param('DateFrom');
			$dateTo = $this->request->param('DateTo');

			//根据序列号查找到表明
			$result = Db::query("select name from nodes where Xlh = {$xlh}");
			//print_r($result[0]['name']);
			$nodename = $result[0]['name'];

			//找到两个日期间的所有时间
			$dt_start = strtotime($dateFrom);
		    $dt_end = strtotime($dateTo);
		    $dates = array();
		    $index = 0;
		    while ($dt_start<=$dt_end){
		        $dates[$index] = date('Y-m-d',$dt_start);
		        $dt_start = strtotime('+1 day',$dt_start);

		        $index++;
		    }
		    //print_r($dates);
		    //查询恶心字段
		   	$datas = array();
		   	$index = 0;
		   	while($index < count($dates)){
		   		$date = $dates[$index];
		   		$result = Db::query("select count(*) AS count,max(p25+0) AS maxp25,max(p10+0) AS maxp10,max(wd+0) AS maxwd,max(sd+0)AS maxsd,min(p25+0) AS minp25,min(p10+0) AS minp10,min(wd+0) AS minwd,min(sd+0)AS minsd,(select count(*) from {$nodename} where time like binary'%{$date}%' and p25>35 ) AS countp25,(select count(*) from {$nodename} where time like binary'%{$date}%' and p10>35 ) AS countp10,(select count(*) from {$nodename} where time like binary'%{$date}%' and wd>35 ) AS counttemperture,(select count(*) from {$nodename} where time like binary'%{$date}%' and sd>35 ) AS counthumidity,time,xlh,(select count(*) from {$nodename} where time like binary'%{$date}%' and p25state=2 ) as p25state2,(select count(*) from {$nodename} where time like binary'%{$date}%' and p10state=2 ) as p10state2,(select count(*) from {$nodename} where time like binary'%{$date}%' and wdstate=2 ) as temperaturestate2,(select count(*) from {$nodename} where time like binary'%{$date}%' and sdstate=2 ) as humiditystate2 FROM {$nodename} where time like binary'%{$date}%'");
		   		$datas[$index] = $result;
		   		$index++;
		   	}
		   	//return $index;
		   	//print_r($datas);

		   	return json($datas);

		}
	}