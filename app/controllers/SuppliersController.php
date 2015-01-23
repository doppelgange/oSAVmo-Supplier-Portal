<?php
class SuppliersController extends BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    //$this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";
    public function getRegister() {
    	//get the supliers in Erply

	    $this->layout->content = View::make('users.register');
	}

	public function postSync() {
		$validator = Validator::make(Input::all(), User::$rules);
	    if ($validator->passes()) {
		    $supplier = new Supplier;
		    $supplier->erplyid = Input::get('erplyid');
		    $supplier->supplierID = Input::get('supplierID');
		    $supplier->supplierType = Input::get('supplierType');
		    $supplier->fullName = Input::get('fullName');
		    $supplier->companyName = Input::get('companyName');
		    $supplier->groupID = Input::get('groupID');
		    $supplier->erplyAdded = Input::get('erplyAdded');
		    $supplier->erplyLastModified = Input::get('erplyLastModified');
		    $supplier->save();
		    return Redirect::to('suppliers/Enquie')->with('message', 'Thanks for registering!');
		} else {
		    return Redirect::to('suppliers/Enquie')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}


}
?>