<?php
	namespace app\index\controller;
	
	use app\index\model\User;
	use think\Db;
	use think\Controller;
	class Login extends Controller{
		
		
		public function login(){
			return $this->fetch();
		}

		public function quit(){
			session('user',null);
			return $this->fetch('login');
		}

		//登陆验证  还未执行加密
		public function verify(){
			$user = $this->request->post();
			//dump($user);
			if($user['username'] == "" || is_null($user['username'])){
				$this->error("用户名密码不能为空");
			}
			$realuser =Db::connect('db_config3')->table('user')->where('username',$user['username'])->find();
			
			//dump($realuser);

			if(is_null($realuser)){
				$this->error("用户名密码错误");
			}else{

				if($realuser['password'] == $user['password']){
 					session('user',$realuser);
					if($realuser['system'] == 0){
						$this->success('登陆成功','home/index/index');
					}else{
						//登陆系统2
						$this->success('登录成功','index/home/index');
					}
					
					
				}else{
					$this->error("用户名密码错误");
				}
			}	

		}

		//注册
		public function register(){
			return $this->fetch();
		}
	}