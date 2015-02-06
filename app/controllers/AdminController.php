<?php

class AdminController extends \BaseController {
	protected $layout = "layouts.main";

	/**
	 * Initiate system for the first time
	 * GET /admin/initiate
	 *
	 * @return Response
	 */
	public function init()
	{
		$message='';
		$alertClass = 'alert-info';
		if(User::all()->count() ==0 ){
			
			User::where('email','=','admin@osavmo.com')->delete();
			User::create(array(
				'lastname' => 'Admin',
				'firstname' => 'User',
				'supplierID' => 0,
				'password' => Hash::make('Password1'),
				'email' => 'admin@osavmo.com'
			));

			//Start: Add Log for user create
			ActionLog::Create(array(
				'module' => 'Product',
				'type' => 'Sync',
				'notes' => 'Admin User is added', 
				'user' => 'System'
			));
			//End: Add Log for user create


			$message .= "Admin user is created for you: <label>User: </label> admin@osavmo.com, <label>Password: </label>Passord1";
		}
		if(Supplier::all()->count() ==0 ){
			if(SyncHelper::syncSuppliers()){
				$message .='<br/>Sync suppliers successfully!';
			}else{
				$message .='<br/>Sync suppliers failed!';
			}
		}
		if(Product::all()->count() ==0 ){
			if(SyncHelper::syncProducts(false,null)){
				$message .='<br/>Sync products successfully!';
			}else{
				$message .='<br/>Sync products failed!';
			}
		}
		if(ProductStock::all()->count()==0 ){
			if(SyncHelper::syncProductStocks()){
				$message .='<br/>Sync stocks successfully!';
			}else{
				$message .='<br/>Sync stocks failed!';
			}
		}

		if(SalesDocument::all()->count()==0){
			if(SyncHelper::syncSalesDocuments(array('dateFrom'=>365))){
				$message .='<br/>Sync sales document successfully!';
			}else{
				$message .='<br/>Sync sales document failed!';
			}
		}

		if($message ==''){
			$message = 'No initiation operation is need at all!';
			$alertClass = 'alert-warning';
		}

		// Session::flash('message', $message); 
		// Session::flash('alert-class', $alertClass); 
		// $this->layout->content = View::make('admin.index'); 
		return Redirect::to('admin')->with(array('message'=>$message,'alert-class'=> $alertClass));
	}



	public function sync(){
		if(SyncHelper::syncSalesDocuments(array('dateFrom'=>365))){
				$message ='<br/>Sync sales document successfully!';
			}else{
				$message ='<br/>Sync sales document failed!';
			}
		return Redirect::to('admin')->with(array('message'=>$message,'alert-class'=> $alertClass));
	}


	/**
	 * Display a listing of the resource.
	 * GET /admin
	 *
	 * @return Response
	 */
	public function index()
	{
		
		// $supplierID = Auth::user()->supplierID;
		// $products = Product::where('supplierID','=',$supplierID)->where('active', '=','1')->paginate(10);
		// //return $products;
		$this->layout->content = View::make('admin.index'); 

		
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /admin/{id}
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
	 * GET /admin/{id}/edit
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
	 * PUT /admin/{id}
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
	 * DELETE /admin/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}