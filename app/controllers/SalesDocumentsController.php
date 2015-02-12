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
		/**/
		if(Auth::user()->isSupplier()){
			$salesDocuments = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*')
            ->where('products.supplierID', '=', Auth::user()->supplierID )
            ->where('sales_documents.source', '=','eShop')
            ->groupBy('sales_documents.salesDocumentID')
            ->distinct()->paginate(10);
		}else{
			$salesDocuments = DB::table('sales_documents')
            ->join('sales_document_items', 'sales_documents.salesDocumentID', '=', 'sales_document_items.salesDocumentID')
            ->join('products', 'sales_document_items.productID', '=', 'products.productID')
            ->select('sales_documents.*')
            ->where('sales_documents.source', '=','eShop')
            ->groupBy('sales_documents.salesDocumentID')
            ->orderBy('sales_documents.date', 'desc')->paginate(10);
		}
		
		$this->layout->content = View::make('salesDocuments.index',array(
			'salesDocuments'=>$salesDocuments
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
		$salesDocument = SalesDocument::find($id);
		$this->layout->content = View::make('salesDocuments.edit',array(
			'salesDocument'=>$salesDocument,
			'next'=>$this->getNextItem($id),
			'deliveryTypes' => DeliveryType::getDeliveryTypeSelect(),
			'previous'=>$this->getPreviousItem($id),
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
		$deliveryTypeIDs = Input::get('deliveryTypeID');
		$salesDocumentItemIDs = Input::get('salesDocumentItemID');
		$message='';
		$alertClass = 'alert-info';

		$getDeliveryTypeSelect = DeliveryType::getDeliveryTypeSelect();
		//Loop item to save
		for($i=0;$i<count($deliveryTypeIDs);$i++){
			$originalItem = SalesDocumentItem::find($salesDocumentItemIDs[$i]);
			$originalID = $originalItem->deliveryTypeID;
			$newID =$deliveryTypeIDs[$i];
			if($originalID!=$newID){
				//do update;
				$originalItem->deliveryTypeID = $newID;
				$originalItem->save();
				//Set message
				$message.=$originalItem->product->name."'s status is updated! from <strong>".$getDeliveryTypeSelect[$originalID]
				."</strong> to <strong>".$getDeliveryTypeSelect[$newID]
				."</strong><br/>";
				//set message class
				$alertClass = 'alert-success';
			}
			if($message == ''){$message = 'Nothing is updated.';}
		}
		//dd($quantities);
		//dd($deliveryTypeIDs);
		//dd($salesDocumentItemIDs);
		return Redirect::to('salesDocuments/'.$id.'/edit')->with(array('message'=>$message,'alertClass'=>$alertClass));
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

	public function getPreviousItem($id){
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
            ->where('sales_documents.date', '<', $salesDocument->date)
            ->orderBy('sales_documents.date', 'desc')->first();
        $previousItemID= is_null($previousItem)? '#':URL::to('salesDocuments').'/'.$previousItem->id;
        return $previousItemID;
	}

	public function getNextItem($id){
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
            ->where('sales_documents.date', '>', $salesDocument->date)
            ->orderBy('sales_documents.date', 'asc')->first();
        $nextItemID= is_null($nextItem)? '#':URL::to('salesDocuments').'/'.$nextItem->id;
        return $nextItemID;
	}


}