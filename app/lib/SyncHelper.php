<?php
class SyncHelper {
	public static function syncSuppliers(){
		$api = new EAPI();
		$result = json_decode(
			$api->sendRequest(
				"getSuppliers", 
				array(
				    "recordsOnPage" =>100,
				    "responseMode" => "detail",
				    //"displayedInWebshop" => 1,
				    //"productID" => 2306	
				)
			), 
			true
		);
		$erplySuppliers = $result['records'];
		if(is_null($erplySuppliers)){
			//Start: Add action log for sync error
			ActionLog::Create(array(
				'module' => 'Supplier',
				'type' => 'Sync',
				'notes' => 'Sync error, no record returned', 
				'user' => 'System'
			));
			//End: Add action log for sync error
			return false;
		}else{

				//Start: Add action log
				ActionLog::Create(array(
					'module' => 'Supplier',
					'type' => 'Sync',
					'notes' => 'Total '.$result['status']['recordsTotal'].' records, sync '.$result['status']['recordsInResponse'].' records', 
					'user' => 'System'
				));
				//End: Add action log

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
			return true;	
		}
	}

	public static function syncProducts($needFilter,$supplierID){
		$api = new EAPI();

		$supplierIDstr= ''; 

		if($needFilter&&$supplierID!=null){
			$supplierIDstr = '"supplierID"=>'.$supplierID;
		}

		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			$result = json_decode(
				$api->sendRequest(
					"getProducts", 
					array(
					    //"getStockInfo"=>1,
						"recordsOnPage" =>1000,
						//"active"=>1,
						$supplierIDstr,
						"pageNo"=>$pageNo
					)
				), 
				true
			);

			$erplyProducts = $result['records'];
			//Get the total records
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/1000);
			}
			//return $totalPage;
			if(is_null($erplyProducts)){
				//Start: Add Log for sync error
				ActionLog::Create(array(
					'module' => 'Product',
					'type' => 'Sync',
					'notes' => 'Page '.$pageNo.' has error, no record returned', 
					'user' => 'System'
				));
				//End: Add Log for sync error
				return false;
			}else{
				//Start: Add action log for sync success
				ActionLog::Create(array(
					'module' => 'Product',
					'type' => 'Sync',
					'notes' => 'Total '.$result['status']['recordsTotal'].' records, sync '.$result['status']['recordsInResponse'].' records on page '.$pageNo.' , Data is from '.Date('Y-m-d', strtotime("-10 days")).' , to '.Date('Y-m-d'), 
					'user' => 'System'
				));
				//End:  Add action log for sync success

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
					$product->erplyAdded = date('y-m-d h:i:s',$erplyProduct['added']) ;
				    $product->erplyLastModified = date('y-m-d h:i:s',$erplyProduct['lastModified']); 
				    $product->save();
				}
					
			}
		}
		return true;
	}

	//Now only warehouse 1 is sync
	public static function syncProductStocks(){
		$api = new EAPI();
		$result = json_decode(
			$api->sendRequest(
				"getProductStock", 
				array(
				    "warehouseID"=>1,
					"getAmountReserved" => 1,
					"getSuggestedPurchasePrice" => 1,
					"getAveragePrices" => 1,
					"getFirstPurchaseDate" => 1,
					"getLastPurchaseDate" => 1,
					"getLastSoldDate" => 1
				)
			), 
			true
		);

		$erplyProductStocks = $result['records'];
		//return $totalPage;
		if(is_null($erplyProductStocks)){
			//Start: Add action log for sync error
			ActionLog::Create(array(
				'module' => 'ProductStock',
				'type' => 'Sync',
				'notes' => 'Sync error, no record returned', 
				'user' => 'System'
			));
			//End: Add action log for sync error

			return false;
		}else{

			//Start: Add action log
			ActionLog::Create(array(
				'module' => 'ProductStock',
				'type' => 'Sync',
				'notes' => 'Total'.$result['status']['recordsTotal'].'Records, sync '.$result['status']['recordsInResponse'].' records', 
				'user' => 'System'
			));
			//End: Add action log

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
			return true;	
		}
	}


	public static function syncSalesDocuments($option = array()){
		$api = new EAPI();
		//Set parameter
		$dateFrom = array_key_exists('dateFrom',$option)? $option['dateFrom']:10;


		$totalPage = 1; // Set default only one page
		for($pageNo=1;$pageNo <= $totalPage;$pageNo++){
			
			$result = json_decode(
				$api->sendRequest(
					"getSalesDocuments", 
					array(
						"recordsOnPage" =>100,
					    "getRowsForAllInvoices" => 1,
					    "getAddedTimestamp" => 1,
					    "getReturnedPayments" =>1,
					    "getCOGS" => 1,
						"pageNo"=>$pageNo,
						"dateFrom" => Date('Y-m-d', strtotime("-".$dateFrom." days"))
					)
				), 
				true
			);
			/*
			$result = json_decode(file_get_contents("SalesDocuments.json"),true);
			*/
			$erplySalesDocuments = $result['records'];
			//Get the total records
			if($result['status']['recordsTotal']!=null){
				$totalPage = ceil($result['status']['recordsTotal']/100);
			}

			if(is_null($erplySalesDocuments)){
				//Start: Add Log for sync error
				ActionLog::Create(array(
					'module' => 'SalesDocument',
					'type' => 'Sync',
					'notes' => 'Page '.$pageNo.' has error, no record returned', 
					'user' => 'System'
				));
				//End: Add Log for sync error
				return false;
			}else{

				//Start: Add action log for sync success
				ActionLog::Create(array(
					'module' => 'SalesDocument',
					'type' => 'Sync',
					'notes' => 'Total '.$result['status']['recordsTotal'].' records, sync '.$result['status']['recordsInResponse'].' records on page '.$pageNo.' , Data is from '.Date('Y-m-d', strtotime("-".$dateFrom." days")).' , to '.Date('Y-m-d'), 
					'user' => 'System'
				));
				//End:  Add action log for sync success

				//Save salesDocument information
				foreach ($erplySalesDocuments as $erplySalesDocument) {
					$salesDocument = SalesDocument::where('salesDocumentID', '=', (int)$erplySalesDocument['id'])->first();
					if (is_null($salesDocument)){
						$salesDocument = new SalesDocument;
						$salesDocument->salesDocumentID = $erplySalesDocument['id'];
					}
					$salesDocument->type = $erplySalesDocument['type'];
					
					if($erplySalesDocument['employeeID']==0){
						$salesDocument->source = 'eShop';
					}else{
						$salesDocument->source = 'Store';
					}
					
					

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
					$salesDocument->internalNotes = trim($erplySalesDocument['internalNotes'], ",");
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
						//$salesDocumentItems = SalesDocumentItem::where('salesDocumentID', '=',$salesDocumentID )->get();
						//return var_dump($salesDocumentItems);


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
		return true;
	}

	




}

?>