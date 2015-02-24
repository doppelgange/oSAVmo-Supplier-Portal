<?php
$sh = new SAPI();

// dd($sh);
try
{

    $call = $sh->call(['URL' => 'products.json', 'METHOD' => 'GET', 'DATA' => ['limit' => 5, 'published_status' => 'any']]);
}
catch (Exception $e)
{
    $call = $e->getMessage();
}

echo '<pre>';
var_dump($call);
echo '</pre>';


?>