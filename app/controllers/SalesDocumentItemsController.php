<?php

class SalesDocumentItemsController extends \BaseController {
	protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /salesdocumentitems
	 *
	 * @return Response
	 */
	public function index()
	{
		$salesDocumentItems = SalesDocumentItem::paginate(10);
		$this->layout->content = View::make('salesDocumentItems.index',array('salesDocumentItems'=>$salesDocumentItems)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /salesdocumentitems/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /salesdocumentitems
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /salesdocumentitems/{id}
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
	 * GET /salesdocumentitems/{id}/edit
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
	 * PUT /salesdocumentitems/{id}
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
	 * DELETE /salesdocumentitems/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}