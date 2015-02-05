<?php 
session_start();
$api = new EAPI();
$suppliers = json_decode(
	$api->sendRequest(
		"getProducts", 
		array(
		    "getStockInfo"=>0,
			"recordsOnPage" => 1,
			//"pageNo"=>$page,
			//"active"=>1,
			//"supplierID"=>7242
		)
	), 
	true
);

print "<pre>";
//print_r(array_map("simplifySuppliers",$suppliers));
print_r($suppliers);
print "</pre>";

?>