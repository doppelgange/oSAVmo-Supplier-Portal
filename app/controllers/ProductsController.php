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
		//Default get the options from URL
		$option['days'] = Input::get('days');
		$option['supplierID'] = Input::get('supplierID');
		//If user is supplier set the supplier ID
		if(Auth::user()->isSupplier()){
			$option['supplierID'] = Auth::user()->supplierID;
		}

		if(SyncHelper::syncProducts($option)){
			return Redirect::to('products')->with('message', 'Sync products successfuly!');
		}else{
			return Redirect::to('products')->with('message', 'Fail to sync products!');
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
		//Check search criteria

		$q=Input::get('q')==null? '':Input::get('q');
		$pagecount = is_numeric(Input::get("pagecount"))? Input::get("pagecount"):10;

		//Init query
		$products =Product::where('active', '=','1');
		//Filter by supplier
		if(Auth::user()->isSupplier()){
			$products = $products->where('supplierID','=',Auth::user()->supplierID);
		}
		//Filter by query
		if($q!=''){
			$products = $products->where('name', 'like','%'.$q.'%')
				->orWhere('nameCN', 'like','%'.$q.'%')
				->orWhere('ean', 'like','%'.$q.'%')
				->orWhere('code', 'like','%'.$q.'%');
		}
		//Paginate
		$products = $products->orderBy('name','asc')
			->paginate($pagecount);
		
		//Create view
		$this->layout->content = View::make('products.inventoryAdjustment',
			array(
				'products'=>$products,
				'q'=>$q)
		); 
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
			'product'=>$product
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
			'previous'=>$this->previous($id,'/edit'),
			'next'=>$this->next($id,'/edit')
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

	/**
	 * Change inventory.
	 * change inventory /products
	 *
	 * @return Response
	 */

	public function inventoryAdjustment(){


		$option['item']=array();
		for($i=0;$i<count(Input::get('toAmount'));$i++){
			//Check whether there is change
			$deltaAmount = Input::get('toAmount')[$i] - Input::get('fromAmount')[$i];
			//If changed, add into list for update.
			if($deltaAmount!=0){
				array_push($option['item'],array(
					'productID' =>Input::get('productID')[$i],
					'fromAmount' =>Input::get('fromAmount')[$i],
					'toAmount' =>Input::get('toAmount')[$i],
					'deltaAmount' =>$deltaAmount
				));
			}
		}

		$option['userName'] = Auth::user()->name();

		$feedback=SaveHelper::inventoryAdjustment($option);
		return Redirect::to('products')->with('message',$feedback['message'] );

	}

	public function previous($id,$modeString=''){
		$current = Product::find($id);
		if(Auth::user()->isSupplier()){
			$previous = Product::where('supplierID','=',Auth::user()->supplierID)
			->where('active', '=','1')
			->where('name', '<', $current->name)
			->orderBy('name','desc')->first();
		}else{
			$previous = Product::where('active', '=','1')
			->where('name', '<', $current->name)
			->orderBy('name','desc')->first();
		}
		$previousID= is_null($previous)? '#':URL::to('products').'/'.$previous->id.$modeString;
		return $previousID;
	}

	public function next($id,$modeString=''){
		$current = Product::find($id);
		if(Auth::user()->isSupplier()){
			$next = Product::where('supplierID','=',Auth::user()->supplierID)
			->where('active', '=','1')
			->where('name', '>', $current->name)
			->orderBy('name','asc')->first();
		}else{
			$next = Product::where('active', '=','1')
			->where('name', '>', $current->name)
			->orderBy('name','asc')->first();
		}
		$nextID= is_null($next)? '#':URL::to('products').'/'.$next->id.$modeString;
		return $nextID;
	}


}