<?php
	namespace app\home\controller;

	use app\index\controller\Common;
	use think\Db;

	class Equitment extends Common{
		
		
		//设备报修信息
		public function setEror(){
			$data = $this->request->post();
			//print_r($data);
			$xlh = $data['equid'];
			$user = $data['name'];
			$phone = $data['phone'];
			$detail = $data['detail'];
			$result = db('nodes','db_config3')->where('xlh',$xlh)->data(['detail' => $detail,'state'=>2,'user'=>$user,'phone'=>$phone])->update();
			if($result == 1){
				$this->success("提交成功",'manager/manage');
				
			}else{
				$this->error("请输入正确的设备编号");
			}
		}

		//确认报修信息，并将设备状态设置为待维修
		public function comfirmToError(){
			$xlh = $this->request->param('xlh');
			$result =db('nodes','db_config3')->where('xlh',$xlh)->data(['state'=>1])->update();

			if($result == 1){
				//$this->success("成功确认",'manager/manage');
				$this->redirect('manager/manage');

			}else{
				$this->error("确认失败，请重试");
			}
		}

		//将维修设备设置成正常设备
		public function comfirmToNormal(){
			$xlh = $this->request->param('xlh');
			$result = $request = db('nodes','db_config3')->where('xlh',$xlh)->data(['state'=>0,'detail' => null,'user'=>null,'phone'=>null])->update();
			if($result == 1){
				$this->redirect('manager/manage');
			}else{
				$this->error("操作失败，请联系管理员");
			}
		}

		//将正常设备设置为待维修设备
		public function comfirmToRepaired(){
			$xlh = $this->request->param('xlh');
			$result = $request = db('nodes','db_config3')->where('xlh',$xlh)->data(['state'=>1])->update();
			if($result == 1){
				$this->redirect('manager/manage');
			}else{
				$this->error("操作失败，请联系管理员");
			}
		}
	}