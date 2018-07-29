<?php
	namespace app\index\controller;

	use think\Controller;
	use think\Request;

	class Common extends Controller{

		public function __construct(Request $request = null){
			parent::__construct($request);
			//执行登陆验证
			if(!session("user")){
				$this->redirect('/index/login/login');
			}
		}

	}