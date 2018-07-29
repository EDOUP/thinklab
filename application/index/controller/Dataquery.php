<?php

namespace app\index\controller;

use app\index\controller\Common;
use app\index\model\Nodes;
class Dataquery extends Common {

	public function temperature(){
		return $this->fetch();
	}
	public function wind(){
		return $this->fetch();
	}
	public function humidity(){
		return $this->fetch();
	}
}

  ?>