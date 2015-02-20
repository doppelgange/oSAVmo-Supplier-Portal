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
		//Sync Supplier
		if(Supplier::all()->count() ==0 ){
			if(SyncHelper::syncSuppliers()){
				$message .='<br/>Sync suppliers successfully!';
			}else{
				$message .='<br/>Sync suppliers failed!';
			}
		}
		//Set defulat vlaue for supplier
		//$affectedRows = Supplier::where('supplierID', 'in', '')->update(array('status' => 2));

		if(User::all()->count() ==0 ){
			//Create User
			$userInfo=array(array(
				'lastname' => 'Bob',
				'firstname' => 'Sun',
				'supplierID' => 0,
				'password' => Hash::make('3792565Jj'),
				'email' => 'bob@osavmo.com'
			),array(
				'lastname' => 'Sunny',
				'firstname' => 'Sun',
				'supplierID' => 0,
				'password' => Hash::make('sun72xin'),
				'email' => 'ssun@osavmo.com'
			),array(
				'lastname' => 'Jinbo',
				'firstname' => 'Chi',
				'supplierID' => 0,
				'password' => Hash::make('Password1'),
				'email' => 'jinbo@osavmo.com'
			),array(
				'lastname' => 'System',
				'firstname' => 'Admin',
				'supplierID' => 0,
				'password' => Hash::make('Password1'),
				'email' => 'admin@osavmo.com'
			));

			foreach($userInfo as $user){
				User::create($user);
				//Start: Add Log for user create
				ActionLog::Create(array(
					'module' => 'User',
					'type' => 'Sync',
					'notes' => 'User '.$user['lastname'].' is added.', 
					'user' => 'System'
				));
				//End: Add Log for user create
			$message .= "User Name:".$user['lastname']." is created for you: <label>Email: </label>".$user['email']."<br/>";
			}
		}

		//Sync Products
		if(Product::all()->count() ==0 ){
			if(SyncHelper::syncProducts()){
				$message .='<br/>Sync products successfully!';
			}else{
				$message .='<br/>Sync products failed!';
			}
		}

		//Sync Stocks
		if(ProductStock::all()->count()==0 ){
			if(SyncHelper::syncProductStocks()){
				$message .='<br/>Sync stocks successfully!';
			}else{
				$message .='<br/>Sync stocks failed!';
			}
		}
		//Sync PriceList Item
		if(PriceListItem::all()->count()==0){
			if(SyncHelper::syncPriceListItems()){
				$message .='<br/>Sync Price List successfully!';
			}else{
				$message .='<br/>Sync Price List failed!';
			}
		}

		//Sync Orders
		if(SalesDocument::all()->count()==0){
			if(SyncHelper::syncSalesDocuments(array('dateFrom'=>30))){
				$message .='<br/>Sync sales document successfully!';
			}else{
				$message .='<br/>Sync sales document failed!';
			}
		}

		//Setup message to display
		if($message ==''){
			$message = 'No initiation operation is need at all!';
			$alertClass = 'alert-warning';
		}

		// Session::flash('message', $message); 
		// Session::flash('alert-class', $alertClass); 
		// $this->layout->content = View::make('admin.index'); 
		return Redirect::to('admin')->with(array('message'=>$message,'alertClass'=> $alertClass));
	}


	public function sync(){
		if(SyncHelper::syncSalesDocuments(array('dateFrom'=>365))){
				$message ='<br/>Sync sales document successfully!';
			}else{
				$message ='<br/>Sync sales document failed!';
			}
		return Redirect::to('admin')->with(array('message'=>$message,'alertClass'=> $alertClass));
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