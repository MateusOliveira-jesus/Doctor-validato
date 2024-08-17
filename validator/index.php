<?php 
require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/api-functions.php');

$response =  api_request('validator_url', 'GET', ['url'=> 'oxmetais.com.br']);

echo"<pre>";
var_dump($response);

// foreach($response['data']['results']['url'] as $key => $link){
//     echo'<duv><a target="_blank" rel="nofollow" href="'.$link.'">'.$link.'</a> </duv><br>';
// }
