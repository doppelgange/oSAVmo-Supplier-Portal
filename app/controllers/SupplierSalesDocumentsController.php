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
		$result = DB::statement('INSERT INTO supplier_sales_documents (supplierID, salesDocumentID, amount, netTotal, vatTotal,total,lastModified,lastModifierUsername,created_at,updated_at) select prod.supplierID, doc.salesDocumentID, @amount := sum(item.amount), @rowNetTotal := sum(item.rowNetTotal), @rowVat := sum(item.rowVat), @rowTotal := sum(item.rowTotal),NOW(),"System",doc.date,NOW() from sales_documents doc, sales_document_items item, products prod where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group by doc.salesDocumentID,prod.supplierID on duplicate key update amount = @amount, netTotal = @rowNetTotal, vatTotal = @rowVat,total = @rowTotal,lastModified = NOW(),lastModifierUsername = "System",updated_at = NOW();');	
		
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
		//dd(Input::get('q'));
		$q['clientName']=Input::get('clientName')==null? '':Input::get('clientName');
		$q['number']=Input::get('number')==null? '':Input::get('number');
		$suppliers = Supplier::getManageableArray();

		//Filter by supplier
		if(Auth::user()->isSupplier()){
			$supplierID = Auth::user()->supplierID;
		}else{
			if(Input::get('supplierID')==null){
				$supplierID = array_keys($suppliers)[0];
			}else{
				$supplierID = Input::get('supplierID');
			}
		}
		$pagecount = is_numeric(Input::get("pagecount"))? Input::get("pagecount"):10;
		//Do the query
		$supplierSalesDocuments = SupplierSalesDocument::where('supplierID','=',$supplierID);
		$supplierSalesDocuments = $supplierSalesDocuments->whereHas('salesDocument', 
			function($query) use($q){
			    if($q['clientName']!=''){
			    	$query->where('clientName','like','%'.$q['clientName'].'%');
			    }
			    if($q['number']!=''){
			    	$query->where('number','like','%'.$q['number'].'%');
			    }
		});
		$supplierSalesDocuments = $supplierSalesDocuments->orderBy('created_at','desc')
			->paginate($pagecount);
		//Create View
		$this->layout->content = View::make('supplierSalesDocuments.index',array(
			'supplierSalesDocuments'=>$supplierSalesDocuments,
			'suppliers'=>$suppliers,
			'supplierID'=>$supplierID,
			'q'=>$q,
		));
		
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
		$supplierSalesDocument = SupplierSalesDocument::find($id);

		$this->layout->content = View::make('supplierSalesDocuments.edit',array(
			'supplierSalesDocument'=>$supplierSalesDocument,
			'next'=>$this->getNextItem($id,'/edit'),
			'supplierID' => Input::get('supplierID'),
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
		$supplierSalesDocument = SupplierSalesDocument::find($id);
		$message="Order ".$supplierSalesDocument->salesDocument->number.' has been fulfilled!';
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
		$supplierSalesDocument = SupplierSalesDocument::find($id);

		//Filer by supplier
		if(Auth::user()->isSupplier()){
        	$previousItem = SupplierSalesDocument::supplierID(Auth::user()->supplierID);
        	$supplierIDString = '?supplierID='.Auth::user()->supplierID;
        }else{
        	if(Input::get('supplierID')==null||Input::get('supplierID')==''){
				$previousItem = new SupplierSalesDocument();
				$supplierIDString='';
			}else{
				$previousItem = SupplierSalesDocument::supplierID(Input::get('supplierID'));
				$supplierIDString = '?supplierID='.Input::get('supplierID');
			}
        }
	    $previousItem = $previousItem->whereHas('salesDocument',function($query) use($supplierSalesDocument){
		    	$query->where('sales_documents.source', '=','eShop')
		    		->where('date','>',$supplierSalesDocument->salesDocument->date)
		    		->orderBy('date','asc');
		    })->first();
        $previousItemID= is_null($previousItem)? '#':
        	URL::to('supplierSalesDocuments').'/'.$previousItem->id.$modeString.$supplierIDString;
        return $previousItemID;
	}

	public function getNextItem($id,$modeString=''){
		$supplierSalesDocument = SupplierSalesDocument::find($id);
		//Filer by supplier
		if(Auth::user()->isSupplier()){
        	$nextItem = SupplierSalesDocument::supplierID(Auth::user()->supplierID);
        	$supplierIDString = '?supplierID='.Auth::user()->supplierID;
        }else{
        	if(Input::get('supplierID')==null||Input::get('supplierID')==''){
				$nextItem = new SupplierSalesDocument();
				$supplierIDString='';
			}else{
				$nextItem = SupplierSalesDocument::supplierID(Input::get('supplierID'));
				$supplierIDString = '?supplierID='.Input::get('supplierID');
			}
        }
	    $nextItem = $nextItem->whereHas('salesDocument',function($query) use($supplierSalesDocument){
		    	$query->where('sales_documents.source', '=','eShop')
		    		->where('date','<',$supplierSalesDocument->salesDocument->date)
		    		->orderBy('date','desc');
		    })->first();
        $nextItemID= is_null($nextItem)? '#':URL::to('supplierSalesDocuments').'/'.$nextItem->id.$modeString.$supplierIDString;
        return $nextItemID;
	}

}