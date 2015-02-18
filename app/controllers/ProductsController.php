<?php

class ProductsController extends \BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    //$this->beforeFilter('auth');
	}

	protected $layout = "layouts.main";



	/**
	 * Syncing products from erply.
	 * GET /products/sync
	 *
	 * @return Response
	 */
	public function sync()
	{
		$option['supplierID'] = Input::get('days');
		$option['supplierID'] = Input::get('supplierID');

		if(SyncHelper::syncProducts($option)){
			return Redirect::to('products')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('products')->with('message', 'Cannot connect to ERPLY!');
		}
	}

	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index()
	{
		// Not ready, allow change paging
		$pagecount = 10;
		if(is_numeric(Input::get("pagecount"))){
			$pagecount = Input::get("pagecount");
		} ;

		if(Auth::user()->isSupplier()){
			$products = Product::where('supplierID','=',Auth::user()->supplierID)->where('active', '=','1')->paginate($pagecount);
		}else{
			$products=Product::paginate($pagecount);
		}
		
		//return $products;
		$this->layout->content = View::make('products.index',array('products'=>$products)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /products
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::find($id);
		// get previous product id
	    
		$this->layout->content = View::make('products.show',array(
			'product'=>$product,
			'next'=>$this->previousProduct($id),
			'previous'=>$this->nextProduct($id)
		)); 
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /products/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);
		// get previous product id
	    
		$this->layout->content = View::make('products.edit',array(
			'product'=>$product,
			'next'=>$this->previousProduct($id),
			'previous'=>$this->nextProduct($id)
		));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		SaveHelper::savePriceList(array(
			'id' => Product::find($id)->productID,
			'from' => Input::get('originalPriceWithVat'),
			'priceWithVat' => Input::get('priceWithVat'),
		));

		return Redirect::to('products/'.$id.'/edit');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function previousProduct($id){
		if(Auth::user()->isSupplier()){
			$previous = Product::where('supplierID','=',Auth::user()->supplierID)
			->where('id', '<', $id)->max('id');
		}else{
			$previous = Product::where('id', '<', $id)->min('id');
		}
		return $previous;
	}

	public function nextProduct($id){
		if(Auth::user()->isSupplier()){
			$next = Product::where('supplierID','=',Auth::user()->supplierID)
			->where('id', '>', $id)->max('id');
		}else{
			$next = Product::where('id', '>', $id)->min('id');
		}
		return $next;
	}

}