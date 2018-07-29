<?php
	namespace app\home\command;

	use think\console\Command;
	use think\console\Input;
	use think\console\Output;
	class Test extends Command{
		protected function configure(){

			$this->setName('Test')->setDescription("计划任务 Test");
		}
		protected function execute(Input $input, Output $output){
	        $output->writeln('Date Crontab job start...');
	        /*** 这里写计划任务列表集 START ***/

	        $this->test();

	        /*** 这里写计划任务列表集 END ***/
	        $output->writeln('Date Crontab job end...');
	    }

	    private function test(){
	    	//获取当前时间 查找
	    	$mydate = date('Y-m-d h:i:s');
	 

	        echo $mydate;
	    }
	}