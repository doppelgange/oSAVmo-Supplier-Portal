<?php

class ProductStocksController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Syncing products from erply.
	 * GET /products/sync
	 *
	 * @return Response
	 */
	public function sync()
	{
		if(SyncHelper::syncProductStocks()){
			return Redirect::to('products')->with('message', 'Sync Successfuly!');
		}else{
			return Redirect::to('products')->with('message', 'Cannot Sync');
		}
	}

	/**
	 * Display a listing of the resource.
	 * GET /productstocks
	 *
	 * @return Response
	 */
	public function index()
	{
		
		// return $supplierID;
		//only return the active items' stock
		$productStocks = ProductStock::whereHas('product', function($q)
		{
			if(Auth::user()->isSupplier()){
				$supplierID = Auth::user()->supplierID;
		    	$q->where('active', '=', '1')->where('supplierID','=',$supplierID);
			}else{
				$q->where('active', '=', '1');
			}
			

		})->paginate(10);

		$this->layout->content = View::make('productStocks.index',array('productStocks'=>$productStocks)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /productstocks/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /productstocks
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /productstocks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$productstocks = ProductStock::find($id);
		// return $productstocks->product()->get();
		$this->layout->content = View::make('users.show',array('user'=>$user,'supplierName'=>$supplierName)); 
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /productstocks/{id}/edit
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
	 * PUT /productstocks/{id}
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
	 * DELETE /productstocks/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}