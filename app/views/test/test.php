<?php 


'SyncSalesDocumentsLog.txt'

Class OsavmoLog{

	var $rootPath = 'log/';
	var $fileName;

	function __construct($n,$p) {
	    $this->$rootPath = 
	    $this->fileName;
	}

	public function start(){
		if(file_exists($rootPath.$fileName)){
			$current = file_get_contents($rootPath.$fileName);
		}else{
			$current='';
		}

		$current .="************************************************\n";
		$current .='Start '.Date('Y-m-d')."\n";
		file_put_contents($rootPath.$fileName, $current);
	}

	public function add($c){
		if(file_exists($rootPath.$fileName)){
			$current = file_get_contents($rootPath.$fileName);
		}else{
			$current='';
		}
		$current .=$c;
		file_put_contents($rootPath.$fileName, $current);
	}

	public function end(){
		if(file_exists($rootPath.$fileName)){
			$current = file_get_contents($rootPath.$fileName);
		}else{
			$current='';
		}

		$current .='End '.Date('Y-m-d')."\n";
		$current .="************************************************\n";
		file_put_contents($rootPath.$fileName, $current);
	}



}





define( 'LOG_ROOT', 'log/' );
$file = $n;
echo LOG_ROOT.$file;



$current .="************************************************\n";
$current .='Start '.Date('Y-m-d')."\n";
$current .='Start '.Date('Y-m-d')."\n";
$current .= "Sync Sales Documents Log \n";
$current .='End '.Date('Y-m-d')."\n";
$current .="************************************************\n";
file_put_contents(LOG_ROOT.$file, $current);
echo file_get_contents(LOG_ROOT.$file);
 
?>
