<?php 
$api = new EAPI();

//Set parameter
$erplyOptions['getPricesWithVAT'] =1;
$erplyOptions['pricelistID'] =Property::env('ErplyPricelistID');
$erplyOptions['getReturnedPayments'] =0;
$erplyOptions['getCOGS'] =1;
$erplyOptions['getAddedTimestamp'] =1;
$erplyOptions['type']='INVWAYBILL';

$option['days']='auto';
$erplyOptions['changedSince'] = syncChangeFromParser(array('data'=>$option,'module'=>'PriceListItem'));

	
$result = json_decode(
	$api->sendRequest(
		"getPriceLists", 
		$erplyOptions
	), 
	true
);

print "<pre>";
print_r($result);
print "</pre>";


function syncChangeFromParser($option){
	$data = $option['data'];
	if(array_key_exists('days',$data)){
		//If sync from last time
		if($data['days']=='auto'){
			if(Property::qget('AutoSyncTimesLog',$option['module'])!=null){
				$returnDate = Property::qget('AutoSyncTimesLog',$option['module'])->value;
			}
		}else{
			$returnDate = strtotime("-".$data['days']." days");
		}
	}
	if(isset($returnDate)==false){
		$returnDate = strtotime("-7 days");
	}
	return $returnDate;
}
?>