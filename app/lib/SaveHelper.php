<?php
class SaveHelper {
	public static function saveSalesDocumentItem($option=array()){
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
			}
			return true;	
		}
	}



	

}

?>