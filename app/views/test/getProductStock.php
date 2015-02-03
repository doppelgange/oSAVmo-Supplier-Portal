<?php 
session_start();
$api = new EAPI();
$suppliers = json_decode(
	$api->sendRequest(
		"getProductStock", 
		array(
		    "warehouseID"=>2,
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
//['records'];


print "<pre>";
//print_r(array_map("simplifySuppliers",$suppliers));
print_r($suppliers);
print "</pre>";

?>