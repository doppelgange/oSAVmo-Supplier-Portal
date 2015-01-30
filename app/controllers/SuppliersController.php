<?php
class SuppliersController extends BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    //$this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";

	public function getNew(){
		$this->layout->content = View::make('suppliers.new'); 
	}

	public function getIndex(){
		$suppliers = Supplier::all();
		$this->layout->content = View::make('suppliers.index',array('suppliers'=>$suppliers)); 
	}


	public function getSync(){
		if(SyncHelper::syncSuppliers()){
			return Redirect::to('suppliers/index')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('suppliers/index')->with('message', 'Cannot connect to ERPLY!');
		}
	}

	public function postAmend(){
		$manageables = Input::get('manageable');
		$erplyIDs = Input::get('erplyID');
		$reslut='';
		foreach($manageables as $k => $v){
			$supplier = Supplier::where('supplierID', '=', $erplyIDs[$k])->first();
			$supplier -> manageable = $v;
			$supplier -> save();
		}

		// return $reslut;
		return Redirect::to('suppliers/index')->with('message', 'Sync to ERPLY Successfuly!');	
	}


}
?>