<?php

class PriceListItemsController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Syncing priceListItems from erply.
	 * GET /priceListItems/sync
	 *
	 * @return Response
	 */
	public function sync()
	{
		$option['days'] = Input::get('days');
		if(SyncHelper::syncPriceListItems($option)){
			return Redirect::to('priceListItems')->with('message', 'Sync Price List Successfuly!');
		}else{
			return Redirect::to('priceListItems')->with('message', 'Sync Error!');
		}
		
	}
	/**
	 * Display a listing of the resource.
	 * GET /pricelistitems
	 *
	 * @return Response
	 */
	public function index()
	{
		$priceListItems = PriceListItem::paginate(10);
		$this->layout->content = View::make('priceListItems.index',array('priceListItems'=>$priceListItems)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /pricelistitems/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /pricelistitems
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /pricelistitems/{id}
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
	 * GET /pricelistitems/{id}/edit
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
	 * PUT /pricelistitems/{id}
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
	 * DELETE /pricelistitems/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}