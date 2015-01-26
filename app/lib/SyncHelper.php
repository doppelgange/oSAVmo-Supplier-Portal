<?php
class SyncHelper {
	public static function syncSupplier(){
		$api = new EAPI();
		$erplySuppliers = json_decode(
			$api->sendRequest(
				"getSuppliers", 
				array(
				    "recordsOnPage" =>100,
				    "responseMode" => "detail"
				    //"displayedInWebshop" => 1,	
				)
			), 
			true
		)['records'];
		if(is_null($erplySuppliers)){
			return false;
		}else{
			foreach ($erplySuppliers as $erplySupplier) {
				$supplier = Supplier::where('supplierID', '=', $erplySupplier['supplierID'])->first();
				if (is_null($supplier)){
					$supplier = new Supplier;
					$supplier->supplierID = $erplySupplier['supplierID'];
				}
				$supplier->erplyid = $erplySupplier['id'];
			    $supplier->supplierType = $erplySupplier['supplierType'];
			    $supplier->fullName = $erplySupplier['fullName'];
			    $supplier->companyName = $erplySupplier['companyName'];
			    $supplier->groupID = $erplySupplier['groupID'];
			    $supplier->erplyAdded = $erplySupplier['added'];
			    $supplier->erplyLastModified = $erplySupplier['lastModified'];
			    $supplier->save();
			}
			return true;	
		}
	}




}

?>