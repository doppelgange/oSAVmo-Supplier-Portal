<?php
class SuppliersController extends BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    //$this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";

	public function sync(){
		if(SyncHelper::syncSuppliers()){
			return Redirect::to('suppliers/index')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('suppliers/index')->with('message', 'Cannot connect to ERPLY!');
		}
	}

	public function batchAmend(){
		$manageables = Input::get('manageable');
		$erplyIDs = Input::get('erplyID');
		$reslut='';
		foreach($manageables as $k => $v){
			$supplier = Supplier::where('supplierID', '=', $erplyIDs[$k])->first();
			$supplier -> manageable = $v;
			$supplier -> save();
		}

		// return $reslut;
		return Redirect::to('suppliers')->with('message', 'Sync to ERPLY Successfuly!');	
	}



	 	/**
	 * Display a listing of the resource.
	 * GET /suppliers
	 *
	 * @return Response
	 */
	public function index()
	{
		$suppliers = Supplier::orderBy('manageable','desc')->orderBy('fullName','asc')->get();
		$this->layout->content = View::make('suppliers.index',array('suppliers'=>$suppliers)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /suppliers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /suppliers
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /suppliers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
?>