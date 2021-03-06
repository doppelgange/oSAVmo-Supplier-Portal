<?php
//image download
function downLoadImage($option=array()){
	$url = $option['url'];
	$fileName = $option['fileName'];
	$destinationPath = $option['destinationPath'];
	$filePath = $destinationPath.$fileName;  			
       	if(file_put_contents($filePath, file_get_contents($url)) != false ){
       		chmod($filePath,0777);
       		return true;
	}
	else{
		return false;
	}
}

//used to 
function syncChangeFromParser($option=array()){

	$data = $option['data'];
	if(array_key_exists('days',$data)){
		//If sync from last time
		if($data['days']=='auto'){
			if(Property::qget('AutoSyncTimesLog',$option['module'])!=null){
				$returnDate = Property::qget('AutoSyncTimesLog',$option['module'])->value;
			}
		}elseif(is_numeric($data['days'])){
			$returnDate = strtotime("-".$data['days']." days");
		}
	}
	if(isset($returnDate)==false){
		$returnDate = strtotime("-7 days");
	}
	return $returnDate;
}


class SyncHelper {
	public static function syncSuppliers($option=array()){
		$api = new EAPI();
		//Set sync day default sync 7 days before
		$erplyOptions['recordsOnPage'] = 100;
		$erplyOptions['responseMode'] = 'detail';
		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'Supplier'));

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','Supplier',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));

		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			//Set Page Number
			$erplyOptions['pageNo']=$pageNo;
			$result = json_decode(
				$api->sendRequest(
					"getSuppliers", 
					$erplyOptions
				), 
				true
			);
			$erplySuppliers = $result['records'];
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/100);
			}

			if($result['status']['responseStatus']!='ok'){
				$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
			}elseif($result['status']['recordsInResponse']==0){
				return true;
			}else{
				$notes = 'Total '.$result['status']['recordsTotal']
					.' records, sync '
					.$result['status']['recordsInResponse'].' records on page '.$pageNo
					.', from '
					.Date('Y-m-d h:i:s',$erplyOptions['changedSince']).' Erply use '
					.number_format($result['status']['generationTime'], 2, '.', '').' seconds. ';

				foreach ($erplySuppliers as $erplySupplier) {
					$supplier = Supplier::where('supplierID', '=', $erplySupplier['supplierID'])->first();
					if (is_null($supplier)){
						$supplier = new Supplier;
						$supplier->supplierID = $erplySupplier['supplierID'];
					}
					$supplier->erplyID = $erplySupplier['id'];
				    $supplier->supplierType = $erplySupplier['supplierType'];
				    $supplier->fullName = $erplySupplier['fullName'];
				    $supplier->companyName = $erplySupplier['companyName'];
				    $supplier->groupID = $erplySupplier['groupID'];
				    $supplier->erplyAdded = date('y-m-d h:i:s',$erplySupplier['added']) ;
				    $supplier->erplyLastModified = date('y-m-d h:i:s',$erplySupplier['lastModified']); 
				    $supplier->save();
				}
				//Start: Add action log
				ActionLog::Create(array(
					'module' => 'Supplier',
					'type' => 'Sync',
					'notes' => $notes, 
					'user' => 'System'
				));
				//End: Add action log
				return true;	
			}
		}
	}


	/**
	 * Sync the products.
	 * GET
	 * Option:
	 * supplierID: filter by given supplier if set
	 *
	 * @return true / false
	 */
	public static function syncProducts($option = array()){
		$api = new EAPI();

		//Set filter by supplier
		if(array_key_exists('supplierID',$option)){
			if($option['supplierID']!=0&&is_numeric ($option['supplierID']))
			$erplyOptions['supplierID'] = $option['supplierID'];
		}
		 
		
		//Set filter by date
		$erplyOptions['recordsOnPage'] = 1000;
		//Set sync day default sync 7 days before
		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'Product'));

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','Product',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));

		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			//Set Page Number
			$erplyOptions['pageNo']=$pageNo;

			$result = json_decode(
				$api->sendRequest(
					"getProducts", 
					$erplyOptions
				), 
				true
			);
			$erplyProducts = $result['records'];
			//Get the total records
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/1000);
			}
			//return $totalPage;
			if($result['status']['responseStatus']!='ok'){
				$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
			}elseif($result['status']['recordsInResponse']==0){
				return true;
			}else{
				$notes = 'Total '.$result['status']['recordsTotal']
					.' records, sync '
					.$result['status']['recordsInResponse'].' records on page '.$pageNo
					.', from '
					.Date('Y-m-d h:i:s',$erplyOptions['changedSince']).' Erply use '
					.number_format($result['status']['generationTime'], 2, '.', '').' seconds. ';
				foreach ($erplyProducts as $erplyProduct) {
					$product = Product::where('productID', '=', (int)$erplyProduct['productID'])->first();
					if (is_null($product)){
						$product = new Product;
						$product->productID = $erplyProduct['productID'];
					}
					//$product->productID = $erplyProduct['productID'];
					$product->name = $erplyProduct['name'];
					$product->code = $erplyProduct['code'];
					$product->ean = $erplyProduct['code2'];
					if (array_key_exists('attributes', $erplyProduct)) {
						$shopifyinfo = $erplyProduct['attributes'];
						foreach ($shopifyinfo as $key => $value) {
							if($value['attributeName'] == 'shopifyId'){
								$product->shopifyID = $value['attributeValue'];
							}
							elseif($value['attributeName'] == 'shopifyCollectId'){
								$product->shopifyCollectID = $value['attributeValue'];
							}
							elseif($value['attributeName'] == 'shopifyVariationId'){
								$product->shopifyVariantID = $value['attributeValue'];
							}
						}						
					}
					$product->nameCN = $erplyProduct['code3'];
					$product->supplierID = $erplyProduct['supplierID'];
					$product->supplierName = $erplyProduct['supplierName'];
					$product->groupID = $erplyProduct['groupID'];
					$product->groupName = $erplyProduct['groupName'];
					$product->categoryID = $erplyProduct['categoryID'];
					$product->categoryName = $erplyProduct['categoryName'];
					$product->seriesID = $erplyProduct['seriesID'];
					$product->seriesName = $erplyProduct['seriesName'];
					$product->unitID = $erplyProduct['unitID'];
					$product->unitName = $erplyProduct['unitName'];
					$product->price = $erplyProduct['price'];
					$product->priceWithVat = $erplyProduct['priceWithVat'];
					$product->cost = $erplyProduct['cost'];
					$product->status = $erplyProduct['status'];
					$product->active = $erplyProduct['active'];
					$product->displayedInWebshop = $erplyProduct['displayedInWebshop'];
					$product->vatrate = $erplyProduct['vatrate'];
					$product->countryOfOriginID = $erplyProduct['countryOfOriginID'];
					$product->brandName = $erplyProduct['brandName'];
					$product->netWeight = $erplyProduct['netWeight'];
					$product->grossWeight = $erplyProduct['grossWeight'];
					$product->volume = $erplyProduct['volume'];
					$product->longdesc = $erplyProduct['longdesc'];
					$product->type = $erplyProduct['type'];
					$product->erplyAdded = date('y-m-d h:i:s',$erplyProduct['added']) ;
				    $product->erplyLastModified = date('y-m-d h:i:s',$erplyProduct['lastModified']); 
				    $product->save();
				}		
			}
			//Start: Add action log for sync success
			ActionLog::Create(array(
				'module' => 'Product',
				'type' => 'Sync',
				'notes' => $notes, 
				'user' => 'System'
			));
			//End:  Add action log for sync success
		}
		// Get tags from shopify
		$sh = new SAPI();
		$args['URL'] = 'products/count.json';
    		$args['METHOD'] = 'GET';
    		$args['DATA'] = array();
    		$count = $sh->call($args);
    		$count = $count -> count;
		$page = ceil($count / 250);

		for ($i=1;$i<=$page;$i++ ){
			$args['URL'] = 'products.json';
    			$args['METHOD'] = 'GET';
    			$args['DATA'] = array('published_status' => 'any','limit' => 250,'page' => $i);
    			$call = $sh->call($args);
    			$products = $call -> products;
    			foreach($products as $key => $value){
    				$shopifyid = $value -> id;
    				$tags = $value -> tags;
    				$product = Product::where('shopifyID', '=', $shopifyid)->first();
    				if(isset($product)){
    					$product->tags= $tags;
    					$product->save();
    				}    						
    			}
		}
		return true;
	}

	//Now only warehouse 1 is sync
	public static function syncProductStocks($option = array()){
		$api = new EAPI();

		//Set parameter
		$erplyOptions = array(
		    "warehouseID"=>1,
			"getAmountReserved" => 1,
			"getSuggestedPurchasePrice" => 1,
			"getAveragePrices" => 1,
			"getFirstPurchaseDate" => 1,
			"getLastPurchaseDate" => 1,
			"getLastSoldDate" => 1
		);
		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'ProductStock'));

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','ProductStock',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));

		$result = json_decode(
			$api->sendRequest(
				"getProductStock", 
				$erplyOptions
			), 
			true
		);

		$erplyProductStocks = $result['records'];
		//return $totalPage;
		if($result['status']['responseStatus']!='ok'){
			$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
		}elseif($result['status']['recordsInResponse']==0){
			return true;
		}else{
			$notes = 'Total '.$result['status']['recordsTotal']
					.' records, sync '.$result['status']['recordsInResponse']
					.' records, from '
					.Date('Y-m-d h:i:s',$erplyOptions['changedSince']).' Erply use '
					.number_format($result['status']['generationTime'], 2, '.', '').' seconds. ';
			foreach ($erplyProductStocks as $erplyProductStock) {
				$productStock = ProductStock::where('productID', '=', (int)$erplyProductStock['productID'])->first();
				if (is_null($productStock)){
					$productStock = new ProductStock;
					$productStock->productID = $erplyProductStock['productID'];
					$productStock->warehouseID = 1;
				}
				//$productStock->productID = $erplyProductStock['productID'];
				$productStock->amountInStock = $erplyProductStock['amountInStock'];
				$productStock->amountReserved = $erplyProductStock['amountReserved'];
				$productStock->suggestedPurchasePrice = $erplyProductStock['suggestedPurchasePrice'];
				$productStock->averagePurchasePrice = $erplyProductStock['averagePurchasePrice'];
				$productStock->averageCost = $erplyProductStock['averageCost'];
				$productStock->firstPurchaseDate = date('Y-m-d H:i:s',strtotime($erplyProductStock['firstPurchaseDate'])) ;
				$productStock->lastPurchaseDate = date('Y-m-d H:i:s',strtotime($erplyProductStock['lastPurchaseDate'])) ;
				$productStock->lastSoldDate = date('Y-m-d H:i:s',strtotime($erplyProductStock['lastSoldDate'])) ;
			    $productStock->save();
			}

			//Start: Add action log
			ActionLog::Create(array(
				'module' => 'ProductStock',
				'type' => 'Sync',
				'notes' => $notes, 
				'user' => 'System'
			));
			// End: Add action log

			// get stock from shopify
			$sh = new SAPI();

			$args['URL'] = 'products/count.json';
    			$args['METHOD'] = 'GET';
    			$args['DATA'] = array();
    			$count = $sh->call($args);
			$count = $count->count;
			$page = ceil($count / 250);
			$recordsCount = 0;
			$a=0;
			for ($i=1;$i<=$page;$i++ ){
				$args['URL'] = 'products.json';
				$args['METHOD'] = 'GET';
				$args['DATA'] = array('published_status' => 'any','limit' => 250,'page' => $i);
				$call = $sh->call($args);
				$products = $call ->products;
				foreach($products as $key => $value){
    					$shopifyid = $value ->id;
    					$variants = $value ->variants;
    					foreach ($variants as $key => $value) {
    						$shopifyVariantID = $value ->id;
    						$shopifyStock = $value ->inventory_quantity;
    						$product = Product::where('shopifyVariantID', '=', $shopifyVariantID)->first();
    						if(isset($product)){
							$productID = $product ->productID;
							$productStocks = ProductStock::where('productID', '=', $productID)->first();
							if(isset($productStocks)){
								$productStocks ->shopifyAmountInStock = $shopifyStock; 
								$productStocks->save();
								$recordsCount ++;
							}					
						}
    					}
				}					
    			}

    			//Start: Add action log
			ActionLog::Create(array(
				'module' => 'ProductStock',
				'type' => 'Sync',
				'notes' => $count.' products in shopify,'.$recordsCount.' products sync successed.', 
				'user' => 'System'
			));
			// End: Add action log

			// Amount Adjustment
			$amountDif = ProductStock::whereNotNull('shopifyAmountInStock')->whereRaw('shopifyAmountInStock <> (amountInStock - amountReserved)')->get();
			if(isset($amountDif)){
				$difCount = count($amountDif);
				$sh = new  SAPI();
				$updateCount = 0;
				foreach ($amountDif as $amountDifItem) {
					$productID = $amountDifItem->productID;
					$amountInStock = $amountDifItem->amountInStock;
					$amountReserved = $amountDifItem->amountReserved;
					$amountAvailable = $amountInStock-$amountReserved;
					$from = $amountDifItem->shopifyAmountInStock;
					$variant = Product::where('productID','=',$productID)->where('displayedInWebshop','=','1')->first();
					if(isset($variant)){
						$shopifyVariantID = $variant->shopifyVariantID;
					}				
					if(isset($shopifyVariantID)){
						$newVariant = array('id' =>$shopifyVariantID,'inventory_quantity'=>$amountAvailable);
						$args['URL'] =  'variants/'.$shopifyVariantID.'.json';
    						$args['METHOD'] = 'PUT';
    						$args['DATA'] = array('variant' => $newVariant);
    						$call = $sh->call($args);
    						$amountDifItem->shopifyAmountInStock=$amountAvailable;
    						$amountDifItem->save();
    						ActionLog::Create(array(
							'module' => 'ProductStock',							
							'type' => 'Adjustment',
							'notes' => 'Stock Amount adjustment success,shopify variant ID: '.$shopifyVariantID.', product ID: '.$productID,
							'from' => $from,
							'to' => $amountAvailable,
							'user' => 'System'
						));
    						$updateCount++;
    					}	
				}
				ActionLog::Create(array(
					'module' => 'ProductStock',							
					'type' => 'Adjustment',
					'notes' => $difCount.' records found, '. $updateCount.' items updtaed successed',
					'user' => 'System'
				));
			}
			else{
				ActionLog::Create(array(
					'module' => 'ProductStock',							
					'type' => 'Adjustment',
					'notes' => 'No adjustment required',
					'user' => 'System'
				));
			}
			return true;			
		}
	}


	public static function syncSalesDocuments($option = array()){
		$api = new EAPI();


		//Set filter by supplier
		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'SalesDocument'));

		$erplyOptions['recordsOnPage'] =100;
		$erplyOptions['getRowsForAllInvoices'] =1;
		$erplyOptions['getReturnedPayments'] =0;
		$erplyOptions['getCOGS'] =1;
		$erplyOptions['getAddedTimestamp'] =1;
		$erplyOptions['type']='INVWAYBILL';

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','SalesDocument',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));


		$totalPage = 1; // Set default only one page
		$totalItemSync = 0;
		$totalItemReturn=0;
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			$erplyOptions['pageNo']=$pageNo;

			$result = json_decode(
				$api->sendRequest(
					"getSalesDocuments", 
					$erplyOptions
				), 
				true
			);

			$erplySalesDocuments = $result['records'];
			//Get the total records
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/100);
			}

			//check status to updates
			if($result['status']['responseStatus']!='ok'){
				$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
			}elseif($result['status']['recordsInResponse']==0){
				return true;
			}else{
				//Save salesDocument information
				foreach ($erplySalesDocuments as $erplySalesDocument) {

					$totalItemReturn++;
					if($erplySalesDocument['employeeID']==0){
						$totalItemSync++;//Count how many sync
						$salesDocument = SalesDocument::where('salesDocumentID', '=', (int)$erplySalesDocument['id'])->first();
						if (is_null($salesDocument)){
							$salesDocument = new SalesDocument;
							$salesDocument->salesDocumentID = $erplySalesDocument['id'];
						}
						$salesDocument->type = $erplySalesDocument['type'];
						$salesDocument->source = 'eShop';

						if(array_key_exists('exportInvoiceType',$erplySalesDocument)){
							$salesDocument->exportInvoiceType = $erplySalesDocument['exportInvoiceType'];
						}
						$salesDocument->currencyCode = $erplySalesDocument['currencyCode'];
						$salesDocument->currencyRate = $erplySalesDocument['currencyRate'];
						$salesDocument->warehouseID = $erplySalesDocument['warehouseID'];
						$salesDocument->warehouseName = $erplySalesDocument['warehouseName'];
						$salesDocument->pointOfSaleID = $erplySalesDocument['pointOfSaleID'];
						$salesDocument->pointOfSaleName = $erplySalesDocument['pointOfSaleName'];
						$salesDocument->pricelistID = $erplySalesDocument['pricelistID'];
						$salesDocument->number = $erplySalesDocument['number'];
						$salesDocument->date = date('y-m-d h:i:s',strtotime($erplySalesDocument['date'].' '.$erplySalesDocument['time']));
						$salesDocument->clientID = $erplySalesDocument['clientID'];
						$salesDocument->clientName = $erplySalesDocument['clientName'];
						$salesDocument->clientEmail = $erplySalesDocument['clientEmail'];
						$salesDocument->clientCardNumber = $erplySalesDocument['clientCardNumber'];
						$salesDocument->addressID = $erplySalesDocument['addressID'];
						if(array_key_exists('address',$erplySalesDocument)){
							$salesDocument->address = $erplySalesDocument['address'];
						}
						$salesDocument->clientPaysViaFactoring = $erplySalesDocument['clientPaysViaFactoring'];
						if(array_key_exists('payerID',$erplySalesDocument)){
							$salesDocument->payerID = $erplySalesDocument['payerID'];
							$salesDocument->payerName = $erplySalesDocument['payerName'];
							$salesDocument->payerAddressID = $erplySalesDocument['payerAddressID'];
							$salesDocument->payerAddress = $erplySalesDocument['payerAddress'];
							$salesDocument->payerPaysViaFactoring = $erplySalesDocument['payerPaysViaFactoring'];

						}
						$salesDocument->contactID = $erplySalesDocument['contactID'];
						$salesDocument->contactName = $erplySalesDocument['contactName'];
						$salesDocument->employeeID = $erplySalesDocument['employeeID'];
						$salesDocument->employeeName = $erplySalesDocument['employeeName'];
						$salesDocument->projectID = $erplySalesDocument['projectID'];
						$salesDocument->invoiceState = $erplySalesDocument['invoiceState'];
						$salesDocument->paymentType = $erplySalesDocument['paymentType'];
						$salesDocument->paymentTypeID = $erplySalesDocument['paymentTypeID'];
						$salesDocument->paymentDays = $erplySalesDocument['paymentDays'];
						$salesDocument->paymentStatus = $erplySalesDocument['paymentStatus'];
						if(array_key_exists('previousReturnsExist',$erplySalesDocument)){
							$salesDocument->previousReturnsExist = $erplySalesDocument['previousReturnsExist'];
						}
						$salesDocument->confirmed = $erplySalesDocument['confirmed'];
						$salesDocument->notes = trim($erplySalesDocument['notes'], ",");

						//Replace the internal notes
						$erplyinternalNotes = urldecode(trim($erplySalesDocument['internalNotes'], ","));
						$pattern = '/(\d\[name\]=)(.*?)(\\\n)(.*?)(\d\[value\]=)(\d{1,2}\/\d{1,2}\/\d{4} \d{1,2}:\d{1,2})(\\\n)?/i';
						$replace = '$2 : $6 <br/> ';
						$erplyinternalNotes = preg_replace($pattern,$replace, $erplyinternalNotes);


						$salesDocument->internalNotes = $erplyinternalNotes;
						$salesDocument->netTotal = $erplySalesDocument['netTotal'];
						$salesDocument->vatTotal = $erplySalesDocument['vatTotal'];
						$salesDocument->rounding = $erplySalesDocument['rounding'];
						$salesDocument->total = $erplySalesDocument['total'];
						$salesDocument->paid = $erplySalesDocument['paid'];
						if(array_key_exists('externalNetTotal',$erplySalesDocument)){
							$salesDocument->externalNetTotal = $erplySalesDocument['externalNetTotal'];
							$salesDocument->externalVatTotal = $erplySalesDocument['externalVatTotal'];
							$salesDocument->externalRounding = $erplySalesDocument['externalRounding'];
							$salesDocument->externalTotal = $erplySalesDocument['externalTotal'];
						}
						$salesDocument->taxExemptCertificateNumber = $erplySalesDocument['taxExemptCertificateNumber'];
						$salesDocument->packerID = $erplySalesDocument['packerID'];
						$salesDocument->referenceNumber = $erplySalesDocument['referenceNumber'];
						$salesDocument->cost = $erplySalesDocument['cost'];
						$salesDocument->reserveGoods = $erplySalesDocument['reserveGoods'];
						$salesDocument->reserveGoodsUntilDate = date('y-m-d h:i:s',strtotime($erplySalesDocument['reserveGoodsUntilDate']));
						$salesDocument->deliveryDate = date('y-m-d h:i:s',strtotime($erplySalesDocument['deliveryDate']));
						$salesDocument->deliveryTypeID = $erplySalesDocument['deliveryTypeID'];
						$salesDocument->deliveryTypeName = $erplySalesDocument['deliveryTypeName'];
						$salesDocument->packingUnitsDescription = $erplySalesDocument['packingUnitsDescription'];
						$salesDocument->triangularTransaction = $erplySalesDocument['triangularTransaction'];
						$salesDocument->purchaseOrderDone = $erplySalesDocument['purchaseOrderDone'];
						$salesDocument->transactionTypeID = $erplySalesDocument['transactionTypeID'];
						$salesDocument->transactionTypeName = $erplySalesDocument['transactionTypeName'];
						$salesDocument->transportTypeID = $erplySalesDocument['transportTypeID'];
						$salesDocument->transportTypeName = $erplySalesDocument['transportTypeName'];
						$salesDocument->deliveryTerms = $erplySalesDocument['deliveryTerms'];
						$salesDocument->deliveryTermsLocation = $erplySalesDocument['deliveryTermsLocation'];
						$salesDocument->euInvoiceType = $erplySalesDocument['euInvoiceType'];
						if(array_key_exists('deliveryOnlyWhenAllItemsInStock',$erplySalesDocument)){
							$salesDocument->deliveryOnlyWhenAllItemsInStock = $erplySalesDocument['deliveryOnlyWhenAllItemsInStock'];	
						}
						$salesDocument->lastModified = date('y-m-d h:i:s',$erplySalesDocument['lastModified']);
						$salesDocument->lastModifierUsername = $erplySalesDocument['lastModifierUsername'];
						$salesDocument->added = date('y-m-d h:i:s',$erplySalesDocument['added']);
						$salesDocument->invoiceLink = $erplySalesDocument['invoiceLink'];
						$salesDocument->receiptLink = $erplySalesDocument['receiptLink'];
						$salesDocument->save();

						//sync SalesDocumentItem
						if(array_key_exists('rows',$erplySalesDocument)){
							$item=$erplySalesDocument['rows'];
							$salesDocumentID = $salesDocument->salesDocumentID;


							for($line=0;$line<count($item);$line++){
								//No exisitng item in system
								$salesDocumentItem = SalesDocumentItem::where('salesDocumentID', '=',$salesDocumentID )->where('line', '=', $line)->first();
								//if line item is not exist
								if(is_null($salesDocumentItem)){
									$salesDocumentItem = new SalesDocumentItem;
									$salesDocumentItem->salesDocumentID = $salesDocument->salesDocumentID;
									$salesDocumentItem->line = $line;
								}
								$salesDocumentItem->productID= $item[$line]['productID'];
								$salesDocumentItem->serviceID= $item[$line]['serviceID'];
								$salesDocumentItem->itemName= $item[$line]['itemName'];
								$salesDocumentItem->code= array_key_exists('code',$item[$line])?$item[$line]['code']:'';
								$salesDocumentItem->vatrateID= $item[$line]['vatrateID'];
								$salesDocumentItem->amount= $item[$line]['amount'];
								$salesDocumentItem->price= $item[$line]['price'];
								$salesDocumentItem->discount= $item[$line]['discount'];
								$salesDocumentItem->finalNetPrice= $item[$line]['finalNetPrice'];
								$salesDocumentItem->finalPriceWithVAT= $item[$line]['finalPriceWithVAT'];
								$salesDocumentItem->rowNetTotal= $item[$line]['rowNetTotal'];
								$salesDocumentItem->rowVAT= $item[$line]['rowVAT'];
								$salesDocumentItem->rowTotal= $item[$line]['rowTotal'];
								$salesDocumentItem->deliveryDate= $item[$line]['deliveryDate'];
								$salesDocumentItem->returnReasonID= $item[$line]['returnReasonID'];
								$salesDocumentItem->employeeID= $item[$line]['employeeID'];
								$salesDocumentItem->campaignIDs= $item[$line]['campaignIDs'];
								$salesDocumentItem->containerID= $item[$line]['containerID'];
								$salesDocumentItem->containerAmount= $item[$line]['containerAmount'];
								$salesDocumentItem->originalPriceIsZero= $item[$line]['originalPriceIsZero'];
								$salesDocumentItem->save();

							}
						}  
					}  
				}
			}
		}

		
		if($totalItemSync>0){
			$notes = 'Total '.$totalItemSync.'records sync (erply:'.$totalItemReturn
					.'), from '
					.Date('Y-m-d h:i:s',$erplyOptions['changedSince']).' Erply Use '
					.number_format($result['status']['generationTime'], 2, '.', '').' seconds. ';

			//Sync supplier sales document table
			$result = DB::statement('INSERT INTO supplier_sales_documents (supplierID, salesDocumentID, amount, netTotal, vatTotal,total,lastModified,lastModifierUsername,created_at,updated_at) select prod.supplierID, doc.salesDocumentID, @amount := sum(item.amount), @rowNetTotal := sum(item.rowNetTotal), @rowVat := sum(item.rowVat), @rowTotal := sum(item.rowTotal),NOW(),"System",doc.date,NOW() from sales_documents doc, sales_document_items item, products prod where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group by doc.salesDocumentID,prod.supplierID on duplicate key update amount = @amount, netTotal = @rowNetTotal, vatTotal = @rowVat,total = @rowTotal,lastModified = NOW(),lastModifierUsername = "System",updated_at = NOW();');	

			//Start: Add action log for sync
			if($result){
				$notes .= 'Sync SupplierSalesDocument successfully';
			}else{
				$notes .= 'Sync SupplierSalesDocument failed';
			};
			ActionLog::Create(array(
				'module' => 'SupplierSalesDocument',
				'type' => 'Sync',
				'notes' => $notes, 
				'user' => 'System'
			));
			//End: Add action log for sync	
		}

		return true;
	}

	public static function syncPriceListItems($option = array()){
		$api = new EAPI();

		//Set parameter
		$erplyOptions['getPricesWithVAT'] =1;
		$erplyOptions['pricelistID'] =Property::env('ErplyPricelistID');
		$erplyOptions['getReturnedPayments'] =0;
		$erplyOptions['getCOGS'] =1;
		$erplyOptions['getAddedTimestamp'] =1;
		$erplyOptions['type']='INVWAYBILL';

		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'PriceListItem'));

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','PriceListItem',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));


		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			
			$result = json_decode(
				$api->sendRequest(
					"getPriceLists", 
					$erplyOptions
				), 
				true
			);

			if($result['status']['responseStatus']!='ok'){
				$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
			}elseif($result['status']['recordsInResponse']==0){
				return true;
			}else{
				$erplyPriceList = $result['records'][0];
				$erplyPriceListItems = $result['records'][0]['pricelistRules'];

				$notes = 'Total '.count($erplyPriceListItems).' records sync. Erply use '
					.number_format($result['status']['generationTime'], 2, '.', '').'seconds';
				//Save priceListItem information
				foreach ($erplyPriceListItems as $erplyPriceListItem) {
					$priceListItem = PriceListItem::where('priceListID', '=', $erplyPriceList['pricelistID'])->
						where('productID','=', $erplyPriceListItem['id'])
						->first();
					if (is_null($priceListItem)){
						$priceListItem = new PriceListItem;
						$priceListItem->pricelistID = $erplyPriceList['pricelistID'];
						$priceListItem->productID = $erplyPriceListItem['id'];
					}

					if(array_key_exists('type',$erplyPriceListItem)){
						$priceListItem->type= $erplyPriceListItem['type'];
					}
					if(array_key_exists('price',$erplyPriceListItem)){
						$priceListItem->price= $erplyPriceListItem['price'];
					}
					if(array_key_exists('priceWithVat',$erplyPriceListItem)){
						$priceListItem->priceWithVat= $erplyPriceListItem['priceWithVat'];
						$originalPrice= Product::where('productID','=', $erplyPriceListItem['id'])->first()->priceWithVat;
						$priceListItem->originalPrice = $originalPrice;
						if($originalPrice!=0){
							$priceListItem->discount = ($originalPrice - ($erplyPriceListItem['priceWithVat']))/$originalPrice;
						}	
					}
					if(array_key_exists('ruleID',$erplyPriceListItem)){
						$priceListItem->ruleID= $erplyPriceListItem['ruleID'];
					}
					if(array_key_exists('amount',$erplyPriceListItem)){
						$priceListItem->amount= $erplyPriceListItem['amount'];
					}
					$priceListItem->save();
					  
				}					
			}

			//Start: Add action log for sync success
			ActionLog::Create(array(
				'module' => 'PriceListItem',
				'type' => 'Sync',
				'notes' =>$notes , 
				'user' => 'System'
			));
			//End:  Add action log for sync success
		}

		//Sync Price from shopify
		$sh = new SAPI();

		$args['URL'] = 'products/count.json';
    		$args['METHOD'] = 'GET';
    		$args['DATA'] = array();
    		$count = $sh->call($args);
		$count = $count->count;
		$page = ceil($count / 250);
		$recordsCount = 0;
		for ($i=1;$i<=$page;$i++ ){
			$args['URL'] = 'products.json';
			$args['METHOD'] = 'GET';
			$args['DATA'] = array('published_status' => 'any','limit' => 250,'page' => $i);
			$call = $sh->call($args);
			$products = $call -> products;
			foreach($products as $key => $value){
    				$shopifyid = $value -> id;
    				$variants = $value -> variants;
    				foreach ($variants as $key => $value) {
    					$shopifyVariantID = $value -> id;
    					$shopifyPrice= $value -> price;
    					$product = Product::where('shopifyVariantID', '=', $shopifyVariantID)->first();
    					if(isset($product)){
						$productID = $product -> productID;
						$productItem = PriceListItem::where('productID', '=', $productID)->first();
						if(isset($productItem)){
							$productItem->shopifyPriceWithGST = $shopifyPrice;
							$productItem->save();
							$recordsCount++;
						}
						else
						{
							//Start: Add action log
							ActionLog::Create(array(
								'module' => 'PriceListItem',
								'type' => 'Sync',
								'notes' => 'Sync from shopify Error,this item is not in erply price list, product ID: '.$productID,
								'user' => 'System'
							));
						}					
					}
					else{
						//Start: Add action log
						ActionLog::Create(array(
							'module' => 'PriceListItem',							
							'type' => 'Sync',
							'notes' => 'Sync from shopify Error,this item is not in product table, shopifyVariantID: '.$shopifyVariantID,
							'user' => 'System'
						));
					}
    				}
			}					
    		}
    		//Start: Add action log
		ActionLog::Create(array(
			'module' => 'PriceListItem',
			'type' => 'Sync',
			'notes' => $count.' products in shopify,'.$recordsCount.' products sync successed.', 
			'user' => 'System'
		));
		//End: Add action log

		// Adjustment between shopify and erply
		$priceDif = PriceListItem::whereNotNull('shopifyPriceWithGST')->whereRaw('shopifyPriceWithGST <> priceWithVat')->get();
		if(isset($priceDif)){
			$difCount = count($priceDif);
			$sh = new  SAPI();
			$updateCount = 0;
			foreach ($priceDif as $priceDifItem) {
				$productID = $priceDifItem->productID;
				$from = $priceDifItem->shopifyPriceWithGST;
				$to = $priceDifItem->priceWithVat;
				$variant = Product::where('productID','=',$productID)->where('displayedInWebshop','=','1')->first();
				if(isset($variant)){
					$shopifyVariantID = $variant->shopifyVariantID;
				}			
				if(isset($shopifyVariantID)){
					$newVariant = array('id' =>$shopifyVariantID,'price'=>$to);
					$args['URL'] =  'variants/'.$shopifyVariantID.'.json';
    					$args['METHOD'] = 'PUT';
    					$args['DATA'] = array('variant' => $newVariant);
    					$call = $sh->call($args);
    					$priceDifItem->shopifyPriceWithGST = $to;
    					$priceDifItem->save();
    					ActionLog::Create(array(
						'module' => 'PriceListItem',							
						'type' => 'Adjustment',
						'notes' => 'Price adjustment success,shopify variant ID: '.$shopifyVariantID.', product ID: '.$productID,
						'from' => $from,
						'to' => $to,
						'user' => 'System'
					));
    					$updateCount++;
    				}	
			}
			ActionLog::Create(array(
				'module' => 'PriceListItem',							
				'type' => 'Adjustment',
				'notes' => $difCount.' records found, '.$updateCount.' items updtaed successed',
				'user' => 'System'
			));
		}
		else{
			ActionLog::Create(array(
				'module' => 'PriceListItem',							
				'type' => 'Adjustment',
				'notes' => 'No adjustment required',
				'user' => 'System'
			));
		}	
		return true;
	}	

	public static function syncDeliveryTypes($option = array()){
		$api = new EAPI();
		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			$result = json_decode(
				$api->sendRequest(
					'getDeliveryTypes', 
					array(
						)
					), 
				true
				);
			$erplyDeliveryTypes = $result['records'];
			if(is_null($erplyDeliveryTypes)){
	 			  //Start: Add Log for sync error
				ActionLog::Create(array(
					'module' => 'DeliveryType',
					'type' => 'Sync',
					'notes' => 'Page has error, no record returned', 
					'user' => 'System'
					));
	 			  //End: Add Log for sync error
				return false;
			}else{
	 			  //Start: Add action log for sync success
				ActionLog::Create(array(
					'module' => 'DeliveryType',
					'type' => 'Sync',
					'notes' => 'Total '.count($erplyDeliveryTypes).' records', 
					'user' => 'System'
					));
	   				//End:  Add action log for sync success

	  			 //Save DeliveryType information
				foreach ($erplyDeliveryTypes as $erplyDeliveryType) {
					$deliveryType = DeliveryType::where('deliveryTypeID', '=', $erplyDeliveryType['deliveryTypeID'])
					->first();
					if (is_null($deliveryType)){
						$deliveryType = new DeliveryType;
						$deliveryType->deliveryTypeID = $erplyDeliveryType['deliveryTypeID'];
					}
					$deliveryType->deliveryTypeID= $erplyDeliveryType['deliveryTypeID'];
					$deliveryType->code= $erplyDeliveryType['code'];
					$deliveryType->name= $erplyDeliveryType['name'];
					$deliveryType->added= $erplyDeliveryType['added'];
					$deliveryType->lastModified= $erplyDeliveryType['lastModified'];
					$deliveryType->save();
				}
			}
		}
		return true;
	}

	//Sync Images
	public static function syncProductsImages($option = array()){
		$api = new EAPI();

		//Set filter by supplier
		if(array_key_exists('supplierID',$option)){
			if($option['supplierID']!=0&&is_numeric ($option['supplierID']))
			$erplyOptions['supplierID'] = $option['supplierID'];
		}
		 	
		//Set filter by date
		$erplyOptions['recordsOnPage'] = 1000;
		//Set sync day default sync 7 days before
		$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'Product'));

		//Update the last auto sync time log to current time
		Property::qsave('AutoSyncTimesLog','ProductImage',time(),'Auto syncTimeLog to'.Date('Y-m-d h:i:s'));

		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			//Set Page Number
			$erplyOptions['pageNo']=$pageNo;

			$result = json_decode(
				$api->sendRequest(
					"getProducts", 
					$erplyOptions
				), 
				true
			);
			$erplyProducts = $result['records'];
			//Get the total records
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/1000);
			}
			//return $totalPage;
			if($result['status']['responseStatus']!='ok'){
				$notes = 'Page has error, no record return, Error code is '.$result['status']['errorCode'];
			}elseif($result['status']['recordsInResponse']==0){
				return true;
			}else{
				$totalImages = 0;
				$successCount = 0;
				$failCount= 0;
				foreach ($erplyProducts as $erplyProduct) {
					$update = false;
					$product = Product::where('productID', '=', (int)$erplyProduct['productID'])->first();			
					if (array_key_exists('images', $erplyProduct)) {
						$productErplyImage = $erplyProduct['images'][0]['smallURL'];					
						$productDataImage = $product->imageLink;
						$productID = $product->productID;
						if(!isset($productDataImage)){						
							$update = true;
						}
						elseif(isset($productDataImage) && $productErplyImage != $productDataImage){							
							$update = true;
						}
						$totalImages ++;
					
						if($update){
							$imageArray['destinationPath'] = public_path().'/images/200x200/';
							$imageArray['url'] = $productErplyImage;
							$imageArray['fileName'] = $productID.'.jpg';
							$result = downLoadImage($imageArray);
							if($result){
								$product->imageLink = $productErplyImage;
								$product->save();
								$successCount++;
							}
							else{
								$failCount++;
							}
						}
					}
				}		
			}
			ActionLog::Create(array(
			'module' => 'ProductImages',
			'type' => 'Sync',
			'notes' => 'There are '.$totalImages.' images in page'. $pageNo.', '
				.$successCount.' images updated,'
				.$failCount. ' images failed. From '
				.Date('Y-m-d h:i:s',$erplyOptions['changedSince']) ,
				'user' => 'System'
			));
		}		
		return true;
	}
}

?>