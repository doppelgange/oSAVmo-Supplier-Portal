<?php 
session_start();


// include ERPLY API class
//include('../vendor/Erply/EAPI.php');

// Initialise class
$api = new EAPI();

// Configuration settings
/*
$api->clientCode = "400206";
$api->username = "doppelganger";
$api->password = "3792565Jj";
$api->url = "https://".$api->clientCode.".erply.com/api/";
*/
/*
$inputParameters= array(
    "active" => 1,
    "recordsOnPage" =>1,
    "categoryID"=>4
    //"displayedInWebshop" => 1,	
);

$result = $api->sendRequest("getProducts", $inputParameters);
*/

// Default output format is JSON, so we'll decode it into a PHP array
$suppliers = json_decode(
	$api->sendRequest(
		"getProducts", 
		array(
		    "recordsOnPage" =>100,
		    "responseMode" => "detail"
		    //"displayedInWebshop" => 1,	
		)
	), 
	true
)['records'];


function simplifySuppliers($s){
	return array($s["id"],$s["companyName"]);
}



print "<pre>";
//print_r(array_map("simplifySuppliers",$suppliers));
print_r($suppliers);
print "</pre>";

?>