<?php
function api_request($endpoint, $method = 'GET', $var = [])
{
    //INICIANDO O CURL DO CLIENT
    $client = curl_init();
    //RETORNA O RESULTADO EM UMA STRING
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    //DEFINE URL
    $url = API_BASE_URL;

    // METHOD GET
    if ($method != 'GET' && $method != 'POST') {
        return "ERROR: METHOD NÃO RECONHECIDO";
    } // CHECA METHOD 
    if ($method == 'GET') {
        $url .= "?endpoint=$endpoint";

        if (!empty($var)) {
            $url .= "&" . http_build_query($var);
        }
    } // METHOD GET

    //METHOD POST
    if ($method == 'POST') {
        $var = array_merge(['endpoint' => $endpoint], $var);
        curl_setopt($client, CURLOPT_POSTFIELDS, $var);
    } //METHOD POST

    curl_setopt($client, CURLOPT_URL, $url);
    $response = curl_exec($client);
    return json_decode($response, true);
}
