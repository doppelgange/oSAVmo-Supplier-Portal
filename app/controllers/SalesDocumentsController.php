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
            ->where('products.productID', '!=', 0 )
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
		$itemID = Input::get('itemID');
		//dd($itemID);
		$fulfillAmount = Input::get('fulfillAmount');
		$salesDocumentID = Input::get('salesDocumentID');
		$message="";
		$alertClass = 'alert-info';
		//Check if only fulfill one item
		if(is_int($itemID)){
			//Fulfill one Item
			$fulfilledItem = SalesDocumentItem::find($itemID);
			$fulfilledItem->fulfilledAmount += $fulfillAmount;
			$fulfilledItem->save();
			$message.=$fulfillAmount." ".$fulfilledItem->product->name." has been fulfilled, total fulfilled amount is ".$fulfilledItem->fulfilledAmount.'. ';
			$alertClass = 'alert-success';
		
			//change the supplier order status
			if(Auth::user()->isSupplier()){
				$supplierID = Auth::user()->supplierID;
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->whereHas('products', function($q){
					$q->where('supplierID', '=', $supplierID);
				})->get();
			}else{
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->get();
			}
			
			$isAllFulfilled = true;
			foreach ($supplierSalesDocumentItems as $salesDocumentItem) {
				if($salesDocumentItem->fulfillAmount<$salesDocumentItem->amount){
					$isAllFulfilled = false;
				}
			}
			if($isAllFulfilled){$message.=' All the items of this order are fulfilled!';};
		}elseif($itemID='*'){
			//Fulfill selected item
			if(Auth::user()->isSupplier()){
				$supplierID = Auth::user()->supplierID;
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->whereHas('products', function($q){
					$q->where('supplierID', '=', $supplierID);
				})->get();
			}else{
				//dd($id);
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->get();
			}
			//dd(SalesDocumentItem::where('salesDocumentID','=',$id));
			foreach($supplierSalesDocumentItems as $salesDocumentItem) {
				//dd($salesDocumentItem);
				$salesDocumentItem->fulfilledAmount = $salesDocumentItem->amount;
				$salesDocumentItem->save();
			}
			$message.=' All the items of this order are fulfilled!';
		}
		
		
	
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
            ->where('sales_documents.date', '<', $salesDocument->date)
            ->orderBy('sales_documents.date', 'desc')->first();
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
            ->where('sales_documents.date', '>', $salesDocument->date)
            ->orderBy('sales_documents.date', 'asc')->first();
        $nextItemID= is_null($nextItem)? '#':URL::to('salesDocuments').'/'.$nextItem->id.$modeString;
        return $nextItemID;
	}


}