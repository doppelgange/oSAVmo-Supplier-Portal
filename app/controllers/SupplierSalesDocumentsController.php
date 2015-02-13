<?php

class SupplierSalesDocumentsController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /suppliersalesdocuments
	 *
	 * @return Response
	 */
	public function index()
	{
		$supplierSalesDocuments = SupplierSalesDocument::paginate(10);
		$this->layout->content = View::make('supplierSalesDocuments.index',array('supplierSalesDocuments'=>$supplierSalesDocuments));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /suppliersalesdocuments/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /suppliersalesdocuments
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /suppliersalesdocuments/{id}
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
	 * GET /suppliersalesdocuments/{id}/edit
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
	 * PUT /suppliersalesdocuments/{id}
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
	 * DELETE /suppliersalesdocuments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}