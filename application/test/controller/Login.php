<?php
	
	namespace app\test\controller;
	use think\Controller;
	use think\Db;
	
	class Login extends Controller{
		
		
		public function login(){
			$data = $this->request->post();
			//$data = input('post');
			//var_dump($data);

			return $data;
		}

		public function index(){
			return $this->fetch();
		}
		public function hello(){
			return 'hello';
		}
	}

