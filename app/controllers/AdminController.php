<?php

class AdminController extends \BaseController {
	protected $layout = "layouts.main";

	/**
	 * Initiate system for the first time
	 * GET /admin/initiate
	 *
	 * @return Response
	 */
	public function initiate()
	{
		
		$userCount = User::all()->count();
		//$userCount = User::where('email','=','admin@osavmo.com')->count();
		$supplierCount = Supplier::all()->count();
		$productCount = Product::all()->count();
		$productStockCount = ProductStock::all()->count();
		$message='';
		$alertClass = 'alert-info';
		if($userCount ==0 ){
			
			User::where('email','=','admin@osavmo.com')->delete();
			User::create(array(
				'lastname' => 'Admin',
				'firstname' => 'User',
				'supplierID' => 0,
				'password' => Hash::make('Passord1'),
				'email' => 'admin@osavmo.com'
			));
			$message .= "Admin user is created for you: <label>User: </label> admin@osavmo.com, <label>Password: </label>Passord1";
		}
		if($supplierCount ==0 ){
			if(SyncHelper::syncSuppliers()){
				$message .='<br/>Sync suppliers successfully!';
			}else{
				$message .='<br/>Sync suppliers failed!';
			}
		}
		if($productCount ==0 ){
			if(SyncHelper::syncProducts(false,null)){
				$message .='<br/>Sync products successfully!';
			}else{
				$message .='<br/>Sync products failed!';
			}
		}
		if($productStockCount ==0 ){
			if(SyncHelper::syncProductStocks()){
				$message .='<br/>Sync stocks successfully!';
			}else{
				$message .='<br/>Sync stocks failed!';
			}
		}

		if($message ==''){
			$message = 'No initiation operation is need at all!';
			$alertClass = 'alert-warning';
		}

		Session::flash('message', $message); 
		Session::flash('alert-class', $alertClass); 
		$this->layout->content = View::make('admin.index'); 
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