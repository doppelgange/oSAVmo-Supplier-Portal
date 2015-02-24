<?php 
session_start();
$api = new EAPI();

$option['days']=1;
$erplyOptions['recordsOnPage'] = 1;
//Set sync day default sync 7 days before
$erplyOptions['changedSince'] = array_key_exists('days',$option) ? strtotime("-".$option['days']." days") : strtotime("-7 days");
//dd($erplyOptions);
//


// array(
// 		    "getStockInfo"=>0,
// 			"recordsOnPage" => 1,
// 			//"changedSince"=> null
// 			"supplierID" => null
// 			//"pageNo"=>$page,
// 			//"active"=>1,
// 			//"supplierID"=>7242
// 		)
dd($property);
$result = json_decode(
	$api->sendRequest(
		"getProducts", 
		$erplyOptions
	), 
	true
);

print "<pre>";
//print_r(array_map("simplifySuppliers",$suppliers));
print_r($result);
print "</pre>";

		

?>