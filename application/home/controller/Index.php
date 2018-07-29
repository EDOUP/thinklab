<?php
	namespace app\home\controller;
	//use think\Controller;
	use app\index\controller\Common;
	class Index extends Common{
		public function index(){
			return $this->fetch();
		}	
		
	}