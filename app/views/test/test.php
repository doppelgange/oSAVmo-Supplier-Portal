<?php


// $appid = 'wx2d3961e92a726ff6';
// $secret = 'b68364c27341496b60a8023ef1d09cc5';

$appid = 'wxc2ac363ae537c5e8';
$secret = 'b0c50cefb4acfb8b0032ba6b8a564aeb';
$response = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret);
// print_r($response);

$response = json_decode($response, true);

$accessToken = $response['access_token'];
echo $accessToken;

// $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$accessToken);

// echo $result;

?>