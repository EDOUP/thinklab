<?php 

namespace app\serviceman\controller;

use app\index\controller\Common;
use think\Db;


class Equipment extends Common{


		public function repair(){
			#用户报修设备
			$repairs=Db::connect('db_config2')->table('book_repair')->select();
			$this->assign('repairs',$repairs);
			#待维修设备
			$waits=Db::connect('db_config2')->table('equip_data')
						->where(['status'=>'待维修'])->order('id')->select();
			$this->assign('waits',$waits);
			#正常设备
			$normals=Db::connect('db_config2')->table('equip_data')
						->where(['status'=>'正常'])->order('id')->select();
			$this->assign('normals',$normals);


			return view('repair');
		}

		public function equipsetwaitrepair(){
		#报修设备设为待维修
		$id=$this->request->param('setid');
		$waits=Db::connect('db_config2')->table('book_repair')->where(['id'=>$id])->delete();
	

		$result=Db::connect('db_config2')->table('equip_data')->where(['id'=>$id])->update(['status'=>'待维修']);
		 return json($result);
		}

	public function equipdelwaitrepair(){
		#删除报修设备
		$id=$this->request->param('delid');
		$waits=Db::connect('db_config2')->table('book_repair')->where(['id'=>$id])->delete();
	
		 return json($waits);
	}


	public function equipsetnormal(){
		#待修设备设为正常
		$id=$this->request->param('setid');
		$result=Db::connect('db_config2')->table('equip_data')->where('id',$id)->update(['status'=>'正常']);
		 return json($result);
	}

	public function equipsetrepair(){
		#正常设备设为待维修
		$id=$this->request->param('setid');
		$result=Db::connect('db_config2')->table('equip_data')->where('id',$id)->update(['status'=>'待维修']);
		 return json($result);
	}


}







 ?>