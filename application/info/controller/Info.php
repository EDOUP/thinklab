<?php
namespace app\info\controller;

use think\Db;
use app\index\controller\Common;
use think\Request;
class Info extends Common
{
    public function index()
    {	
     return view('info');
    }
   
  
}
