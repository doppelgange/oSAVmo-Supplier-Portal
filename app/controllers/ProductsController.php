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
	public function sync($s)
	{
		//return $s;
		$supplierID = Auth::user()->supplierID;
		$needFilter= true;
		if($s=='all'){
			$needFilter=false;
			$supplierID = null;
		}
		//return SyncHelper::syncProducts(null,null);
		if(SyncHelper::syncProducts($needFilter,$supplierID)){
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

		$supplierID = Auth::user()->supplierID;
		$products = Product::where('supplierID','=',$supplierID)->where('active', '=','1')->paginate($pagecount);
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
	    $previous = Product::where('id', '<', $product->id)->max('id');

	    // get next product id
	    $next = Product::where('id', '>', $product->id)->min('id');
		// return array($product,$product->productStocks,DB::getQueryLog());
		//$product->productStocks;
		//return array($product->productStocks->$amountInStock);
		$this->layout->content = View::make('products.show',array(
			'product'=>$product,
			'next'=>$next,
			'previous'=>$previous
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
		$this->show($id);
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
		//
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

}