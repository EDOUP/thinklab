<?php
namespace app\index\controller;

use think\Db;
use app\index\controller\Common;
use think\Request;
class Home extends Common
{

  

    public function index()
    {	
     return view('home');
    }
   
   public function  menuLeft(){

     $res= Db::Connect('db_config1')->table('nodes')->select();
    	return json($res);
   }

  
}
