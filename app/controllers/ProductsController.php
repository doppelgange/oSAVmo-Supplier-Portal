<?php

class ProductsController extends \BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    $this->beforeFilter('auth');
	}

	protected $layout = "layouts.main";

	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */

	/*
	public function getIndex()
	{
		$products = Product::all();
		$this->layout->content = View::make('products.index',array('products'=>$products)); 
	}
	*/

	public function getIndex()
	{
		$supplierID = Auth::user()->supplierID;
		$products = Product::where('supplierID','=',$supplierID);
		$this->layout->content = View::make('products.index',array('products'=>$products)); 
	}
	/**
	 * Show the form for syncing products from erply for supplier.
	 * GET /products/sync
	 *
	 * @return Response
	 */
	public function getSync()
	{
		$supplierID = Auth::user()->supplierID;
		if(SyncHelper::syncProducts($supplierID)){
			return Redirect::to('products/index')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('products/index')->with('message', 'Cannot connect to ERPLY!');
		}
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
		//
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
		//
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