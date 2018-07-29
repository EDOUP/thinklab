<?php

namespace app\index\controller;

use app\index\controller\Common;
use think\Db;

class Equipment extends Common{


	public function index(){
		return $this->fetch('equipment');
	}

	public function equipinput(){
		

		return view('equipinput');
	}
	public function equipAddone(){
		$data    =$this->request->post();
		$id      = $data['id'];
		$type    = $data['type'];
		$version = $data['version'];
		$date    = $data['date'];
		$rtmp    = $data['rtmp'];
		$company = $data['company'];
		$address = $data['address'];
		$lng     = $data['lng'];
		$lat     = $data['lat'];
		$linkman = $data['linkman'];
		$tel     = $data['tel'];
		$result=db('equip_data','db_config2')->insertGetId([		
					'id'           =>$id,      
					'type'         =>$type,   
					'version'      =>$version,
					'install_date' =>$date,  
					'co_lng'       =>$lng,
					'co_lat'       =>$lat,  
					'rtmp'         =>$rtmp, 
					'company'      =>$company,
					'co_addr'      =>$address,
					'co_linkman'   =>$linkman,
					'co_tel'       =>$tel,
					'status'       =>"正常",			    
					
		]);
		return json($result);
	}
	


	#设备管理->设备查询
	public function equipsearch(){
		#显示所有设备
		$equips=db('equip_data','db_config2')
						->order("id")
						->select();
			$this->assign('equips',$equips);
		return $this->fetch('equipsearch');
	}

	#查询某一设备ajax
	public function equipsearchone(){
		
		$id     =$this->request->param('number');
		$result =db('equip_data','db_config2')
					->where(['id'=>$id])->select();
		 return json($result);
	}
	#查看监控链接
	public function equipsearchlink(){
		$id     =$this->request->param('searchid');
		$result =db('equip_data','db_config2')
					->where(['id'=>$id])->field("rtmp")->select();
		 return json($result);
	}
	#修改设备信息
	public function equipupdate(){
		// oldId:this.old_id,newId:newId,newType:newType,newVersion:newVersion,newDate:newDate,newRtmp:newRtmp,newCompany:newCompany,newAddress:newAddress,newLinkman:newLinkman,newTel:newTel
		$data       =$this->request->post();
		$oldId      = $data['oldId'];
		$newId      = $data['newId'];
		$newType    = $data['newType'];
		$newVersion = $data['newVersion'];
		$newDate    = $data['newDate'];
		$newRtmp    = $data['newRtmp'];
		$newCompany = $data['newCompany'];
		$newAddress = $data['newAddress'];
		$newLinkman = $data['newLinkman'];
		$newTel     = $data['newTel'];
		$result=db('equip_data','db_config2')->where("id",$oldId)->update([		
					'id'=>$newId,      
					'type'=>$newType,   
					'version'=>$newVersion,
					'install_date'=>$newDate,    
					'rtmp'=>$newRtmp, 
					'company'=>$newCompany,
					'co_addr'=>$newAddress,
					'co_linkman'=>$newLinkman,
					'co_tel'=>$newTel,
		]);
		return json($result);
	}
	#删除设备
	public function equipdelete(){
		$id=$this->request->param('searchid');
		$result=db('equip_data','db_config2')->where(['id'=>$id])->field("id")->delete();
		 return json($result);
	}


	#设备管理->设备保修
	public function equiprepair(){
		#用户报修设备
			$repairs=Db::connect('db_config2')->order("index")->table('book_repair')->select();
			$this->assign('repairs',$repairs);
			#待维修设备
			$waits=db('equip_data','db_config2')
						->where(['status'=>'待维修'])->order("id")->select();
			$this->assign('waits',$waits);
			#正常设备
			$normals=db('equip_data','db_config2')
						->where(['status'=>'正常'])->order("id")->select();
			$this->assign('normals',$normals);
		
		return $this->fetch('equiprepair');
	}
	public function equipsetwaitrepair(){
		#报修设备设为待维修
		$id    =$this->request->param('setid');
		$waits =Db::connect('db_config2')->table('book_repair')
						->where(['id'=>$id])->delete();
	

		$result=db('equip_data','db_config2')
					->where(['id'=>$id])->update(['status'=>'待维修']);
		 return json($result);
	}

	public function equipdelwaitrepair(){
		#删除报修设备
		$id    =$this->request->param('delid');
		$waits =Db::connect('db_config2')->table('book_repair')
						->where(['id'=>$id])->delete();
	
		 return json($waits);
	}


	public function equipsetnormal(){
		#待修设备设为正常
		$id     =$this->request->param('setid');
		$result =db('equip_data','db_config2')
					->where(['id'=>$id])->update(['status'=>'正常']);
		 return json($result);
	}

	public function equipsetrepair(){
		#正常设备设为待维修
		$id     =$this->request->param('setid');
		$result =db('equip_data','db_config2')
					->where(['id'=>$id])->update(['status'=>'待维修']);
		 return json($result);
	}
	#节点管理
	public function nodemanage(){
		return $this->fetch('nodemanage');
	}

}

  ?>