<?php



// $property = Property::qsave('AutoSyncTimesLog','Product',time(),'Auto syncTimeLog');


$sh = new SAPI();

// dd($sh);
try
{

    $call = $sh->call(['URL' => 'orders.json', 'METHOD' => 'GET', 'DATA' => ['status'=>'any']]);
}
catch (Exception $e)
{
    $call = $e->getMessage();
}

echo '<pre>';
var_dump($call);
echo '</pre>';


?>