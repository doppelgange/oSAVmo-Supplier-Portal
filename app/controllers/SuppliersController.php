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

	public function getEnquire(){
		$suppliers = Supplier::all();
		$this->layout->content = View::make('suppliers.enquire',array('suppliers'=>$suppliers)); 
	}


	public function getSync(){
		if(SyncHelper::syncSupplier()){
			return Redirect::to('suppliers/enquire')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('suppliers/enquire')->with('message', 'Cannot connect to ERPLY!');
		}
	}

	public function postAmend(){
		$manageables = Input::get('manageable');
		$erplyids = Input::get('erplyid');
		$reslut='';
		foreach($manageables as $k => $v){
			$supplier = Supplier::where('supplierID', '=', $erplyids[$k])->first();
			$supplier -> manageable = $v;
			$supplier -> save();
		}

		// return $reslut;
		return Redirect::to('suppliers/enquire')->with('message', 'Sync to ERPLY Successfuly!');	
	}


}
?>