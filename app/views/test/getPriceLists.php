<?php 
session_start();

$api = new EAPI();

$salesDocuments = json_decode(
	$api->sendRequest(
		"getPriceLists", 
		array(
			"getPricesWithVAT"=> 1,
			"pricelistID" => 8
			//"changedSince" => Date('Y-m-d', strtotime("-".$dateFrom." days"))
		)
	), 
	true
);


$salesDocuments = $salesDocuments['records'][0];
print "<pre>";
print_r($salesDocuments);
print "</pre>";

?>