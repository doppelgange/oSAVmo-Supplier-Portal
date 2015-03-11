<?php

//Set filter by supplier
$option = array('days'=>'7');
$erplyOptions['changedSince'] = Helpers::syncChangeFromParser(array('data'=>$option,'module'=>'SalesDocument'));

$erplyOptions['recordsOnPage'] =100;
$erplyOptions['getRowsForAllInvoices'] =1;
$erplyOptions['getReturnedPayments'] =0;
$erplyOptions['getCOGS'] =1;
$erplyOptions['getAddedTimestamp'] =1;
$erplyOptions['type']='INVWAYBILL';
$erplyOptions['number']='102270';
$api = new EAPI();
$result = json_decode(
	$api->sendRequest(
		"getSalesDocuments", 
		$erplyOptions
	), 
	true
);

$erplySalesDocuments = $result['records'];

$erplySalesDocument = $erplySalesDocuments[0]['internalNotes'];


$erplyinternalNotes = urldecode(trim($erplySalesDocument, ","));
$pattern = '/(\d\[name\]=)(.*?)(\\\n)(.*?)(\d\[value\]=)(\d{1,2}\/\d{1,2}\/\d{4} \d{1,2}:\d{1,2})(\\\n)?/i';
$replace = '$2 : $6 <br/> ';
$erplyinternalNotes = preg_replace($pattern,$replace, $erplyinternalNotes);

dd($erplyinternalNotes);




$notes = '0[name]=mi-sushi-Pick-Up-Date\n0[value]=3/12/2015 12:20';
$notes = urldecode($notes);

$pattern = '/(\d\[name\]=)(.*?)(\\\n)(.*?)(\d\[value\]=)(\d{1,2}\/\d{1,2}\/\d{4} \d{1,2}:\d{1,2})(\\\n)?/i';
$replace = '$2 : $6 <br/> ';
preg_replace($pattern,$replace, $notes);


echo preg_replace($pattern,$replace, $notes);
 

?>