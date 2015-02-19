

<?php 
$sh = App::make('ShopifyAPI', [
	'API_KEY' => 'f3190abd0d6ef1023cd57770358713f3', 
	'API_SECRET' => '48627be563928d831a0719cd73f8ba66', 
	'SHOP_DOMAIN' => 'gooya.myshopify.com', 
	'ACCESS_TOKEN' => 'd4d5c90913c9ebc2daabf58dba1539ce'
]);

//$sh->installURL(['permissions' => array('write_orders', 'write_products')]);


try
{

    $call = $sh->call([
    	'URL' => 'products.json', 
    	'METHOD' => 'GET', 
    	'DATA' => ['limit' => 50, 'published_status' => 'any']
    ]);
}
catch (Exception $e)
{
    $call = $e->getMessage();
}

echo '<pre>';
var_dump($call);
echo '</pre>';


?>