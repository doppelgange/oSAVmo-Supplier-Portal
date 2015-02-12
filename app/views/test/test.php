<?php
// Initialise class
$api = new EAPI();

	//$productIDs="1791,1912,1911,1910,1882,1338,1788,1881,1880,1878,1879,1789";
//Print the result into csv
	$fp = fopen('product-2015-02-12.csv', 'w');
	$title=array(
"productID","name","code3","code2","code","Has Image","longdesc","groupID","groupName","categoryID","categoryName","type","price","priceWithVat","displayedInWebshop","shopifyId","shopifyCollectId","shopifyVariationId","active","added","lastModified","netWeight","grossWeight","supplierID","unitID","vatrateID","supplierCode","priorityGroupID","countryOfOriginID","volume","seriesID","containerID","cost","vatrate","unitName","brandID","brandName","seriesName","supplierName","warehouseID","totalInStock","orderPending","description"
	);
	fputcsv($fp, $title);

//Loop to show the content
for($page=1;$page<20;$page++){
	// Get client groups from API
	$inputParameters = array(
		//"productIDs"=>$productIDs,
		"getStockInfo"=>1,
		"recordsOnPage" =>1000,
		"pageNo"=>$page,
		"active"=>1,
	    );
	$result = $api->sendRequest("getProducts",$inputParameters);
	//

	// Default output format is JSON, so we'll decode it into a PHP array
	$output = json_decode($result, true);
	echo "*******************************************<br/>";
	echo "Loop $page has " , count($output["records"]) ,"records<br/>" ;
	/*
	echo "<br/>*******************************************<br/>";
	print_r($output);
	print "</pre>";
	echo "<br/>*******************************************<br/>";
	*/




	foreach ($output["records"] as $fields) {
		//Check whether Image exist
		if(isset($fields["images"])) {
			$hasImage = count($fields["images"])==0? "No Image":"Has Image";
		} else {
			$hasImage = "No Image";
		}
		
		//Check whether shpify field exist   "shopifyId","shopifyCollectId","shopifyVariationId"
		if(isset($fields["attributes"][0]["attributeValue"])){
			$shopifyId="\t".$fields["attributes"][0]["attributeValue"]." ";
		} else{
			$shopifyId="No shopifyId";
		}

		if(isset($fields["attributes"][1]["attributeValue"])){
			$shopifyCollectId="\t".$fields["attributes"][0]["attributeValue"]." ";
		} else{
			$shopifyCollectId="No shopifyCollectId";
		}

		if(isset($fields["attributes"][2]["attributeValue"])){
			$shopifyVariationId="\t".$fields["attributes"][0]["attributeValue"]." ";
		} else{
			$shopifyVariationId="No shopifyVariationId";
		}


		$flat=array(
			$fields["productID"]." ",
			$fields["name"]." ",
			iconv("UTF-8","gb2312//TRANSLIT//IGNORE",$fields["code3"]." "),
			"\t".$fields["code2"]." ",
			"\t".$fields["code"]." ",
			$hasImage." ",
			strlen($fields["longdesc"])." ",
			$fields["groupID"]." ",
			$fields["groupName"]." ",
			$fields["categoryID"]." ",
			$fields["categoryName"]." ",
			$fields["type"]." ",
			$fields["price"]." ",
			$fields["priceWithVat"]." ",
			$fields["displayedInWebshop"]." ",
			$shopifyId." ",
			$shopifyCollectId." ",
			$shopifyVariationId." ",
			$fields["active"]." ",
			date("Y/m/d H:i:s",$fields["added"])." ",
			date("Y/m/d H:i:s",$fields["lastModified"])." ",
			$fields["netWeight"]." ",
			$fields["grossWeight"]." ",
			$fields["supplierID"]." ",
			$fields["unitID"]." ",
			$fields["vatrateID"]." ",
			$fields["supplierCode"]." ",
			$fields["priorityGroupID"]." ",
			$fields["countryOfOriginID"]." ",
			$fields["volume"]." ",
			$fields["seriesID"]." ",
			$fields["containerID"]." ",
			$fields["cost"]." ",
			$fields["vatrate"]." ",
			$fields["unitName"]." ",
			$fields["brandID"]." ",
			$fields["brandName"]." ",
			$fields["seriesName"]." ",
			$fields["supplierName"]." ",
			$fields["warehouses"][1]["warehouseID"]." ",
			$fields["warehouses"][1]["totalInStock"]." ",
			$fields["warehouses"][1]["orderPending"]." ",
			$fields["description"]." "
		);
	    fputcsv($fp, $flat);
	}

	
}

//Close file in the end
echo fclose($fp);



?>
