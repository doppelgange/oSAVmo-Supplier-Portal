

<?php 
session_start();

$api = new EAPI();

$result = json_decode(
	$api->sendRequest(
		"getReasonCodes", 
		array(
			// 'stocktakingID'=>3,
			// 'productID1'=> 1676,
			// 'countPcs1' => 111
		)
	), 
	true
);


// $result = $result['records'][0];
print "<pre>";
print_r($result);
print "</pre>";

?>