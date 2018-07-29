<?php

namespace app\index\controller;

use app\index\controller\Common;
use think\Db;

class Usermanage extends Common{

	public function index(){
		#查询维修人员
		$serviceman=db('user','db_config3')->where(['system'=>'1','authority'=>'1'])->select();
		$this->assign('services',$serviceman);
		#查询用户
		$users=db('user','db_config3')->where(['system'=>'1','authority'=>'2'])->select();
		$this->assign('users',$users);
		return view('usermanage');
	}
	#更改维修人员信息
	public function	changeServiceMan(){
		$username=$this->request->param('tel');
		$name=$this->request->param('servicename');
		$psword=$this->request->param('psword');
		$email=$this->request->param('email');	
		$user=db('user','db_config3')->where(['username'=>$username])->find();	
		if($user==null){
		#插入
			$result=db('user','db_config3')->insertGetId([				
					'username'=>$username, 
					'name'=>$name, 
					'password'=>md5($psword),
					'type'=>'serviceman',
					'company'=>'HQU',
					'email'=>$email ,
					'system'=>'1',
					'authority'=>'2'
			]);
			return json($result);
		}else{
		#更新
		$result=db('user','db_config3')->where( ['username'=>$username])->update([					
					'name'=>$name, 
					'password'=>md5($psword),
					'company'=>'HQU',
					'email'=>$email 
			]);		
		return json($result);
		
		}		
	}

	#删除维修人员
	public function deleteServiceMan(){
		$username=$this->request->param('id');
		$result=db('user','db_config3')->where(['username'=>$username])->delete();
		return json($result);
	}
	#查找某人拥有的设备
	public function searchEquip(){
		#tel为唯一标志
			$tel=$this->request->param('searchtel');
			$equips=db('equip_data','db_config2')->where(['owner'=>$tel])->field('id')->select();
			return json($equips);
	}
	#删除某用户的一台设备
	public function delectOneEquip(){
		$id=$this->request->param('delectId');
		$result=db('equip_data','db_config2')->where(['id'=>$id])->update(['owner'=>'']);
		return json($result);

	}
	#给某用户添加一台设备
	public function AddOneEquip(){
		#用户账号
		$usernum=$this->request->param('usernumber');
		#设备号
		$id=$this->request->param('equipid');
		$result=db('equip_data','db_config2')->where(['id'=>$id])->update(['owner'=>$usernum]);
		return json($result);

	}

}

  ?>