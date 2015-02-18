<?php 
session_start();

$api = new EAPI();

$salesDocuments = json_decode(
	$api->sendRequest(
		"savePriceList", 
		array(
			"pricelistID"=> 8,
			"type1" => "PRODUCT",
			"id1" => 1677,
			"price1" => 9.03,
			"attributeName1" =>"lastModifyBy",
			"attributeValue1" => "Bob Sun",
			"attributeName1" =>"updateChannel",
			"attributeValue1" => "Supplier Portal API"
		)
	), 
	true
);


$salesDocuments = $salesDocuments['records'][0];
print "<pre>";
print_r($salesDocuments);
print "</pre>";

?>