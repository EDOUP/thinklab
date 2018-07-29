<?php
	
	namespace app\home\controller;

	use app\index\controller\Common;
	use app\home\model\Nodes;
	use think\Db;
	use app\home\model\EquitmentPojo;

	/**
	 <li ><a href="/home/ztree/init">首页</a></li>
					          <li><a href="/home/manager/pm25">PM2.5</a></li>
					          <li><a href="/home/manager/pm10">PM10</a></li>
					          <li><a href="/home/manager/temperature">温度</a></li>
					          <li><a href="/home/manager/humidity">湿度</a></li>
							  <li><a href="/home/manager/manage">管理</a></li>
	*/
	class manager extends Common{

		public function pm25(){

			return $this->fetch();
		}

		public function pm10(){

			return $this->fetch();
		}
		public function temperature(){

			return $this->fetch();
		}
		public function humidity(){

			return $this->fetch();
		}
		//管理界面初始化
		public function manage(){

			//展示设备信息及其状态
			$nodes = Db::connect('db_config3')->query('select name from nodes where state is not null');

			//print_r($data);
			$result = array();
			$i = 0;
			foreach ($nodes as $value) {
				//var_dump($value);
				$data = Db::connect('db_config3')->query("select a.xlh,a.name,a.state,a.detail,a.user,a.phone,b.bh,b.version,b.gsdm from nodes as a,{$value['name']} as b where a.xlh = b.xlh limit 1");
				$result[$i] = $data[0];
				$i++;
			}

			$this->assign("datas",$result);
			

			return $this->fetch();
		}

	}