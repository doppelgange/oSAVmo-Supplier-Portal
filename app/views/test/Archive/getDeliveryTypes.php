<?php 
session_start();

$api = new EAPI();
$pageNo = 1;

$dateFrom = 100;
$result = json_decode(
	$api->sendRequest(
		"getDeliveryTypes", 
		array(
			// "pageNo"=>$pageNo,
			// "getPricesWithVAT"=> 1,
			// "pricelistID" => 8
			//"changedSince" => Date('Y-m-d', strtotime("-".$dateFrom." days"))
		)
	), 
	true
);


//$salesDocuments = $salesDocuments['records'][0];
print "<pre>";
print_r($result);
print "</pre>";

?>