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
		$option['days'] = Input::get('days');
		if(SyncHelper::syncSalesDocuments($option)){
			return Redirect::to('salesDocuments')->with('message', 'Sync orders successfuly!');
		}else{
			return Redirect::to('salesDocuments')->with('message', 'Fail to sync orders!');
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
 		$q['clientName']=Input::get('clientName')==null? '':Input::get('clientName');
		$q['number']=Input::get('number')==null? '':Input::get('number');
		$pagecount = is_numeric(Input::get("pagecount"))? Input::get("pagecount"):10;

		$salesDocuments = SalesDocument::where('sales_documents.source', '=','eShop');
		if($q['clientName']!=''){
			$salesDocuments=$salesDocuments->where('clientName','like','%'.$q['clientName'].'%');
		}
		if($q['number']!=''){
			$salesDocuments=$salesDocuments->where('number','like','%'.$q['number'].'%');
		}
		$salesDocuments = $salesDocuments->orderBy('sales_documents.date', 'desc')
			->paginate($pagecount);

		$this->layout->content = View::make('salesDocuments.index',array(
			'salesDocuments'=>$salesDocuments,
			'q'=>$q
		));
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
		
		//$supplierID = Auth::user()->supplierID;
		$salesDocument = SalesDocument::find($id);
		//return $salesDocument;

		$this->layout->content = View::make('salesDocuments.show',array(
			'salesDocument'=>$salesDocument,
			'next'=>$this->getNextItem($id),
			'previous'=>$this->getPreviousItem($id),
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
		//$this->show($id);
		$salesDocumentID = SalesDocument::find($id)->salesDocumentID;
		$salesDocument = SalesDocument::where('salesDocumentID','=',$salesDocumentID)->first();
		$this->layout->content = View::make('salesDocuments.edit',array(
			'salesDocument'=>$salesDocument,
			'next'=>$this->getNextItem($id,'/edit'),
			'deliveryTypes' => DeliveryType::getDeliveryTypeSelect(),
			'previous'=>$this->getPreviousItem($id,'/edit'),
		));  
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

	public function getPreviousItem($id,$modeString=''){
		$salesDocument = SalesDocument::find($id);
		// get previous product id
	    $previousItem = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*');
        if(Auth::user()->isSupplier()){
        	$previousItem=$previousItem->where('products.supplierID', '=', Auth::user()->supplierID);
        } 
        $previousItem = $previousItem->where('sales_documents.source', '=','eShop')
            ->where('sales_documents.date', '>', $salesDocument->date)
            ->orderBy('sales_documents.date', 'asc')->first();
        $previousItemID= is_null($previousItem)? '#':URL::to('salesDocuments').'/'.$previousItem->id.$modeString;
        return $previousItemID;
	}

	public function getNextItem($id,$modeString=''){
		$salesDocument = SalesDocument::find($id);
		// get next product id
	    $nextItem = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*');
        if(Auth::user()->isSupplier()){
        	$nextItem=$nextItem->where('products.supplierID', '=', Auth::user()->supplierID);
        } 
        $nextItem = $nextItem->where('sales_documents.source', '=','eShop')
            ->where('sales_documents.date', '<', $salesDocument->date)
            ->orderBy('sales_documents.date', 'desc')->first();
        $nextItemID= is_null($nextItem)? '#':URL::to('salesDocuments').'/'.$nextItem->id.$modeString;
        return $nextItemID;
	}


}