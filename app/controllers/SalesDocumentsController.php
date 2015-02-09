<?php

class SalesDocumentsController extends \BaseController {


	protected $layout = "layouts.main";



	/**
	 * Syncing salesDocuments from erply.
	 * GET /salesDocuments/sync
	 *
	 * @return Response
	 */
	public function sync()
	{
		//return SyncHelper::syncSalesDocuments();
		/**/
		if(SyncHelper::syncSalesDocuments()){
			return Redirect::to('salesDocuments')->with('message', 'Sync to ERPLY Successfuly!');
		}else{
			return Redirect::to('salesDocuments')->with('message', 'Cannot connect to ERPLY!');
		}
		
	}

	/**
	 * Display a listing of the resource.
	 * GET /salesdocuments
	 *
	 * @return Response
	 */
	public function index()
	{
		




		$supplierID = Auth::user()->supplierID;
		if(is_null($supplierID)){
			$salesDocuments=null;
		}elseif($supplierID==0){
			$salesDocuments = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*')
            ->where('sales_documents.source', '=','eShop')
            ->orderBy('sales_documents.date', 'desc')
            ->distinct()
            ->paginate(10);
		}else{
			$salesDocuments = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*')
            ->where('products.supplierID', '=', $supplierID )
            ->where('sales_documents.source', '=','eShop')
            ->orderBy('sales_documents.date', 'desc')
            ->distinct()
            ->paginate(10);
		}
		
        //return $salesDocuments;
        //$salesDocuments = SalesDocument::where('source', '=', 'eShop')->orderBy('date','desc')->paginate(10);
		$this->layout->content = View::make('salesDocuments.index',array('salesDocuments'=>$salesDocuments)); 

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /salesdocuments/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /salesdocuments
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /salesdocuments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$salesDocument = SalesDocument::find($id);
		//return $salesDocument;
		// get previous product id
	    $previous = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*')
            ->where('sales_documents.source', '=','eShop')
            ->where('sales_documents.date', '<', $salesDocument->date)
            ->orderBy('sales_documents.date', 'desc')->first()->id;
	    //SalesDocument::where('source', '=', 'eShop')->where('id', '<', $salesDocument->id)->max('id');

	    // get next product id
	    $next = SalesDocument::where('source', '=', 'eShop')->where('id', '>', $salesDocument->id)->min('id');
		$this->layout->content = View::make('salesDocuments.show',array(
			'salesDocument'=>$salesDocument,
			'next'=>$next,
			'previous'=>$previous
		)); 
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /salesdocuments/{id}/edit
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
	 * PUT /salesdocuments/{id}
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
	 * DELETE /salesdocuments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}