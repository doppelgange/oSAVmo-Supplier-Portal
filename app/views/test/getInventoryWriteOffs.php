

<?php 
session_start();

$api = new EAPI();


//Save Stocktaking
$result = json_decode(
	$api->sendRequest(
		"getInventoryWriteOffs", 
		array(
			//'creatorID'	=>1,
			// 'reasonID'=>1,
			// 'warehouseID'=>1,
			// 'comments' => 'This is a test by bob using API',	
			// 'productID1'=> 1676,
			// 'amount1' => 111
			//'confirmed'=>1
		)
	), 
	true
);


// $result = $result['records'][0];
print "<pre>";
print_r($result);
print "</pre>";

?>