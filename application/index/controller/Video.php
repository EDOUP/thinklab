<?php

namespace app\index\controller;

use app\index\controller\Common;

class Video extends Common{

	public function index(){

		$this->assign('id','00000001');
		$this->assign('time',time());
		return view('video');
	}
}

  ?>