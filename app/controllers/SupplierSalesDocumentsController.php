<?php

class SupplierSalesDocumentsController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Init the data from sales document.
	 * GET /suppliersalesdocuments
	 *
	 * @return Response
	 */
	public function sync()
	{
		$result = DB::statement('INSERT INTO supplier_sales_documents (supplierID, salesDocumentID, amount, netTotal, vatTotal,total,lastModified,lastModifierUsername,created_at,updated_at) select prod.supplierID, doc.salesDocumentID, @amount := sum(item.amount), @rowNetTotal := sum(item.rowNetTotal), @rowVat := sum(item.rowVat), @rowTotal := sum(item.rowTotal),NOW(),"System",NOW(),NOW() from sales_documents doc, sales_document_items item, products prod where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group by doc.salesDocumentID,prod.supplierID on duplicate key update amount = @amount, netTotal = @rowNetTotal, vatTotal = @rowVat,total = @rowTotal,lastModified = NOW(),lastModifierUsername = "System",updated_at = NOW();');	
		
		//Start: Add action log for sync
		if($result){
			$notes = 'Sync SupplierSalesDocument successfully';
		}else{
			$notes = 'Sync SupplierSalesDocument failed';
		};
		ActionLog::Create(array(
			'module' => 'SupplierSalesDocument',
			'type' => 'Sync',
			'notes' => $notes, 
			'user' => 'System'
		));
		//End: Add action log for sync
		return Redirect::to('supplierSalesDocuments');
	}

	/**
	 * Display a listing of the resource.
	 * GET /suppliersalesdocuments
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->layout->headline = 'Order List';
		if(Auth::user()->isSupplier()){

			$supplierSalesDocuments = SupplierSalesDocument::where('supplierID','=',Auth::user()->supplierID)
			->orderBy('created_at','desc')->paginate(10);
			//dd($salesDocuments);
			$this->layout->content = View::make('supplierSalesDocuments.index',array(
				'supplierSalesDocuments'=>$supplierSalesDocuments
			));
		}else{
			return Redirect::to('salesDocuments');
		}
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
	 * GET /suppliersalesdocuments/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//$this->show($id);
		$salesDocumentID = SalesDocument::find($id)->salesDocumentID;
		$supplierSalesDocument = SupplierSalesDocument::where('salesDocumentID','=',$salesDocumentID)
		->where('supplierID','=',Auth::user()->supplierID)->first();
		$this->layout->content = View::make('supplierSalesDocuments.edit',array(
			'supplierSalesDocument'=>$supplierSalesDocument,
			'next'=>$this->getNextItem($id,'/edit'),
			'deliveryTypes' => DeliveryType::getDeliveryTypeSelect(),
			'previous'=>$this->getPreviousItem($id,'/edit'),
		));  
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

		$itemID = Input::get('itemID');
		$fulfillAmount = Input::get('fulfillAmount');
		$salesDocumentID = Input::get('salesDocumentID');
		$supplierID = Auth::user()->supplierID;
		$message="";
		$alertClass = 'alert-info';
		//Check if only fulfill one item
		if($itemID!='*'&&$itemID!=''){
			//Fulfill one Item
			$fulfilledItem = SalesDocumentItem::find($itemID);
			$fulfilledItem->fulfilledAmount += $fulfillAmount;
			$fulfilledItem->save();
			$message.=$fulfillAmount." ".$fulfilledItem->product->name." has been fulfilled, total fulfilled amount is ".$fulfilledItem->fulfilledAmount.'. ';
			$alertClass = 'alert-success';
		
			//change the supplier order status
			if(Auth::user()->isSupplier()){
				$supplierSalesDocumentItems = SalesDocument::find($id)->supplierSalesDocumentItems();
				//dd(count($supplierSalesDocumentItems));
			}else{
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->get();
			}
			
			$isAllFulfilled = true;
			foreach ($supplierSalesDocumentItems as $supplierSalesDocumentItem) {
				if($supplierSalesDocumentItem->fulfilledAmount<$supplierSalesDocumentItem->amount){
					//dd($supplierSalesDocumentItem);
					$isAllFulfilled = false;
				}
			}
			if($isAllFulfilled){

				$supplierSalesDocument = SupplierSalesDocument::where('salesDocumentID','=',$salesDocumentID)
				->where('supplierID','=',$supplierID)->first();
				$supplierSalesDocument->status = 'Completed';
				$supplierSalesDocument->save();

				$message.=' All the items of this order are fulfilled!';
			};
		}elseif($itemID=='*'){

			//Fulfill selected item
			if(Auth::user()->isSupplier()){
				//dd($supplierID);
				$supplierSalesDocumentItems = SalesDocumentItem::where('salesDocumentID','=',$salesDocumentID)->whereHas('product', function($q) use ($supplierID){
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
			//Set the supplier sales document status
			$supplierSalesDocument = SupplierSalesDocument::where('salesDocumentID','=',$salesDocumentID)
			->where('supplierID','=',$supplierID)->first();
			$supplierSalesDocument->status = 'Completed';
			$supplierSalesDocument->save();

			$message.=' All the items of this order are fulfilled!';
		}
		
		
	
		return Redirect::to('supplierSalesDocuments/'.$id.'/edit')->with(array('message'=>$message,'alertClass'=>$alertClass));
	
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

	/**
	 * Remove the specified resource from storage.
	 * Fulfill /suppliersalesdocuments/{id}/fulfill
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function fulfill($id)
	{
		$alertClass = 'alert-success';
		$salesDocument = SalesDocument::find($id);
		$supplierID = Auth::user()->supplierID;
		$supplierSalesDocument = SupplierSalesDocument::where('salesDocumentID','=',$salesDocument->salesDocumentID)
		->where('supplierID','=',$supplierID)->first();


		$message="Order ".$salesDocument->number.' has been fulfilled!';
		//Set status for supplier order
		$supplierSalesDocument->status='Completed';
		$supplierSalesDocument->save();
		//Set fulfilled amount for item
		foreach ($supplierSalesDocument->supplierSalesDocumentItems() as $supplierSalesDocumentItem) {
			$supplierSalesDocumentItem->fulfilledAmount = $supplierSalesDocumentItem->amount;
			$supplierSalesDocumentItem->save();
		}
		return Redirect::to('supplierSalesDocuments')->with(array('message'=>$message,'alertClass'=>$alertClass));
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
        $previousItemID= is_null($previousItem)? '#':URL::to('supplierSalesDocuments').'/'.$previousItem->id.$modeString;
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
        $nextItemID= is_null($nextItem)? '#':URL::to('supplierSalesDocuments').'/'.$nextItem->id.$modeString;
        return $nextItemID;
	}

}