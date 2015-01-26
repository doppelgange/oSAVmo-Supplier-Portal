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
		$api = new EAPI();
		$erplySuppliers = json_decode(
			$api->sendRequest(
				"getSuppliers", 
				array(
				    "recordsOnPage" =>100,
				    "responseMode" => "detail"
				    //"displayedInWebshop" => 1,	
				)
			), 
			true
		)['records'];
		if(is_null($erplySuppliers)){
			return Redirect::to('suppliers/enquire')->with('message', 'Cannot connect to ERPLY!');
		}else{
			foreach ($erplySuppliers as $erplySupplier) {
				$supplier = Supplier::where('supplierID', '=', $erplySupplier['supplierID'])->first();
				if (is_null($supplier)){
					$supplier = new Supplier;
					$supplier->supplierID = $erplySupplier['supplierID'];
				}
				$supplier->erplyid = $erplySupplier['id'];
			    $supplier->supplierType = $erplySupplier['supplierType'];
			    $supplier->fullName = $erplySupplier['fullName'];
			    $supplier->companyName = $erplySupplier['companyName'];
			    $supplier->groupID = $erplySupplier['groupID'];
			    $supplier->erplyAdded = $erplySupplier['added'];
			    $supplier->erplyLastModified = $erplySupplier['lastModified'];
			    $supplier->save();
			}
			return Redirect::to('suppliers/enquire')->with('message', 'Sync to ERPLY Successfuly!');	
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