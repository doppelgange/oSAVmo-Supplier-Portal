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
				'type' => 'Update',
				'from' => $option['from'],
				'to' => $option['priceWithVat'],
				'notes' => $option['id'], 
				'user' => Auth::user()->name()
			));
			//End: Add action log for sync error
	}



	

}

?>