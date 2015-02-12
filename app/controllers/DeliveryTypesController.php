<?php

class DeliveryTypesController extends \BaseController {

	protected $layout = "layouts.main";
  /**
  * Syncing deliveryTypes from erply.
  * GET /deliveryTypes/sync
  *
  * @return Response
  */
	public function sync()
	{
		if(SyncHelper::syncDeliveryTypes()){
			return Redirect::to('deliveryTypes')->with('message', 'Sync DeliveryType Successfuly!');
		}else{
			return Redirect::to('deliveryTypes')->with('message', 'Sync Error!');
		}
		
	}
	/**
	 * Display a listing of the resource.
	 * GET /deliverytypes
	 *
	 * @return Response
	 */
	public function index()
	{
		$deliveryTypes = DeliveryType::paginate(10);
		$this->layout->content = View::make('deliveryTypes.index',array('deliveryTypes'=>$deliveryTypes));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /deliverytypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /deliverytypes
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /deliverytypes/{id}
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
	 * GET /deliverytypes/{id}/edit
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
	 * PUT /deliverytypes/{id}
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
	 * DELETE /deliverytypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}