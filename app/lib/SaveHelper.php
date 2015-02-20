<?php
class SaveHelper {
	public static function savePriceList($option=array()){
		$api = new EAPI();
		$erplyOption = array(
			"pricelistID"=> 8,
			"type1" => "PRODUCT",
			"id1" => $option['id'],
			"price1" => $option['priceWithVat']/1.15,
			"attributeName1" =>"lastModifyBy",
			"attributeValue1" => Auth::user()->name(),
			"attributeName1" =>"updateChannel",
			"attributeValue1" => "Supplier Portal API"
		);
		$result = json_decode(
			$api->sendRequest(
				"savePriceList", 
				$erplyOption
			), 
			true
		);

		$priceListItem = PriceListItem::where('productID','=',$option['id'])->first();
		$priceListItem->price = $option['priceWithVat']/1.15;
		$priceListItem->priceWithVat = $option['priceWithVat'];
		$priceListItem->save();

		//SyncHelper::syncPriceListItems();
		//Start: Add action log for sync error
		ActionLog::Create(array(
			'module' => 'priceList',
			'type' => 'Update priceWithVat',
			'from' => $option['from'],
			'to' => $option['priceWithVat'],
			'notes' => 'productID: '.$option['id'], 
			'user' => Auth::user()->name()
		));
		//End: Add action log for sync error
	}



	public static function inventoryAdjustment($option=array()){
		//If no item
		if(!array_key_exists('item',$option)&&count($option['item']==0)){
			$feedback['message'] = 'Failed to add inventory for product.';
			return $feedback;
		}

		//If there is item
		$api = new EAPI();
		//Set parameter for erply

		$erplyOption['creatorID'] = 601;
		$erplyOption['reasonID'] = 5;
		$erplyOption['warehouseID'] = 1;
		$option['userName'] = array_key_exists('userName', $option)? $option['userName'] : 'Unknown User';
		$erplyOption['comments'] = 'Updated by Supplier Portal, User is '.$option['userName'].'at'.date("Y-m-d h:i:s");
		for($i = 0;$i<count($option['item']);$i++){
			$j = $i+1;
			$erplyOption['productID'.$j] = $option['item'][$i]['productID'];
			$erplyOption['amount'.$j] = $option['item'][$i]['deltaAmount'];

			//Add action log
			//Start: Add action log for inventory Registration 
			ActionLog::Create(array(
				'module' => 'InventoryAdjustment ',
				'type' => 'Request Inventory Adjustment',
				'from' => $option['item'][$i]['fromAmount'],
				'to' => $option['item'][$i]['toAmount'],
				'notes' => 'productID: '.$option['item'][$i]['productID'], 
				'user' => Auth::user()->name()
			));
			//End: Add action log for inventory Registration 

		}
		 
		$result = json_decode(
			$api->sendRequest(
				"saveInventoryRegistration", 
				$erplyOption
			), 
			true
		);

		if($result['status']['responseStatus']=='ok'){
			//Update DB
			for($i=0;$i<count($option['item']);$i++){
				$productStock = ProductStock::where('warehouseID','=',1)
				->where('productID','=',$option['item'][$i]['productID'])->first();
				$productStock->amountInStock = $option['item'][$i]['toAmount'];
				$productStock->save();
			}
			ActionLog::Create(array(
				'module' => 'InventoryAdjustment ',
				'type' => 'Save to Supplier Portal',
				'notes' => 'Save Amendmend to DB', 
				'user' => 'System'
			));

			//Set feedback info
			$feedback['status'] = 'success';
			$feedback['message'] = 'Inventory is updated successfully.';
			$feedback['source'] = $result;
			return $feedback;
		}

	}

	

}

?>