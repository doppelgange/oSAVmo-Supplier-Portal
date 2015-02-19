<?php 
session_start();

$api = new EAPI();
$pageNo = 1;

$dateFrom = 10;
$salesDocuments = json_decode(
	$api->sendRequest(
		"getProductPictures"
	), 
	true
);
/*
ActionLog::Create(array(
	'module' => 'SalesDocument',
	'type' => 'Sync',
	'notes' => 'Total'.$salesDocuments['status']['recordsTotal'].'Records, sync '.$salesDocuments['status']['recordsInResponse'].' records on page '.$pageNo.'From Date '.Date('Y-m-d', strtotime("-10 days")).' , To Date '.Date('Y-m-d'), 
	'user' => 'System'
));
*/
//['records']
print "<pre>";
print_r($salesDocuments);
print "</pre>";

?>