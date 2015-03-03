<?php



// $property = Property::qsave('AutoSyncTimesLog','Product',time(),'Auto syncTimeLog');


$sh = new SAPI();

// dd($sh);
try
{

    $call = $sh->call(['URL' => 'products/437840524.json', 'METHOD' => 'GET', 'DATA' => []]);
}
catch (Exception $e)
{
    $call = $e->getMessage();
}

echo '<pre>';
var_dump($call);
echo '</pre>';


?>