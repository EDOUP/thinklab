<?php
namespace app\index\controller;

/**
	入口文件判断session是否登陆信息  如果没有
*/
class Index extends Common
{
    public function index(){
    	
    	return "index";
	}
	
	public function test(){
		return 'success';
	}
}
