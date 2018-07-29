<?php 
namespace app\user\controller;

use app\index\controller\Common;
use think\Db;

class Bookrepair extends Common{

	public function bookrepair(){
			if($_POST!=null){// 报修设备数据录入
			$person   = addslashes($_POST['person']);
			$tel      = addslashes($_POST['tel']);
			$id       = addslashes($_POST['id']);
			$description = addslashes($_POST['describe']);
			$date     = date("Y-m-d H:i:s",time()) ;
			if(empty($person) || empty($tel) || empty($id) || empty($description) ){
			$response = 0;
		
			}
			else{
			$this->assign("err","提交成功");
			$res=Db::connect('db_config2')->table('book_repair')->insert([
			'id'=>$id,'date'=>$date,'person'=>$person,'tel'=>$tel,'description'=>$description,'status'=>'待维修']);
			}
			}
			else{$this->assign("editerr","");}
		
			
		
	
		return view('bookrepair');
	}

	public function bookrepairup(){


			if($_POST!=null){// 报修设备数据录入
			$person   = addslashes($_POST['person']);
			$tel      = addslashes($_POST['tel']);
			$id       = addslashes($_POST['id']);
			$description = addslashes($_POST['describe']);
			$date     = date("Y-m-d H:i:s",time()) ;
			if(empty($person) || empty($tel) || empty($id) || empty($description) ){
			$response = 0;
		
			}
			else{
			$this->assign("err","提交成功");
			$res=Db::connect('db_config2')->table('book_repair')->insert([
			'id'=>$id,'date'=>$date,'person'=>$person,'tel'=>$tel,'description'=>$description,'status'=>'待维修']);
			}
			}
			else{$this->assign("editerr","");}
		
			
		
		#避免刷新页面提交缓存数据 
		return redirect('/user/bookrepair/bookrepair');
	}




}




 ?>