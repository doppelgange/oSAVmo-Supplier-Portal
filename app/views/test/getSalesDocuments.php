<?php 
session_start();

$api = new EAPI();
$pageNo = 1;

$salesDocuments = json_decode(
	$api->sendRequest(
		"getSalesDocuments", 
		array(
		    "recordsOnPage" =>100,
		    "getRowsForAllInvoices" => 1,
		    "getAddedTimestamp" => 1,
		    "getReturnedPayments" =>1,
		    "getCOGS" => 1,
			"pageNo"=>$pageNo,
			'employeeID' =>0,
			"dateFrom" => Date('Y-m-d', strtotime("-10 days"))
		)
	), 
	true
);

ActionLog::Create(array(
	'module' => 'SalesDocument',
	'type' => 'Sync',
	'notes' => 'Total'.$salesDocuments['status']['recordsTotal'].'Records, sync '.$salesDocuments['status']['recordsInResponse'].' records on page '.$pageNo.'From Date '.Date('Y-m-d', strtotime("-10 days")).' , To Date '.Date('Y-m-d'), 
	'user' => 'System'
));

//['records']
print "<pre>";
print_r($salesDocuments);
print "</pre>";

?>