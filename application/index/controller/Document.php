<?php

namespace app\index\controller;

use app\index\controller\Common;
use think\Db;

class Document extends Common{

	public function index(){
		$this->assign('fileSelect','null');
		$this->assign('err','警告，未选择任何文件');
		
	
		$files=Db::connect('db_config2')->table('files')->select();
		$this->assign('files',$files);
		$this->assign('filesLength',sizeof($files));

		return view('document');
	}
}

  ?>