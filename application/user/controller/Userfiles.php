<?php 
namespace app\user\controller;

use app\index\controller\Common;
use think\Db;

class Userfiles extends Common{

	public function userfiles(){
		
		$files=Db::connect('db_config2')->table('files')->select();
		$this->assign('files',$files);
		$this->assign('filesLength',sizeof($files));
		return view('userfiles');
	}




}




 ?>