<?php
// CHAMANDO MINHAS DEPENDECIAS 
require_once(dirname(__FILE__) . '/inc/api-response.php');
require_once(dirname(__FILE__) . '/inc/api-logic.php');

//INSTANCIA DA API_CLASS
$api_response = new api_response();


//CONDICION CHECK METHOD
if (!$api_response->check_method($_SERVER['REQUEST_METHOD'])) {
    $api_response->api_request_error('ERROR: METHOD NÃO RECONHECIDO');
} //END DEBUG METHOD

//DEFININDO METHOD NO DATA
$api_response->set_method($_SERVER['REQUEST_METHOD']);

$params = null;
if ($api_response->get_method() == 'GET') {
    // DEFINE QUAL SERÁ O ENDPPOINTER GET E SETA A VARIAVEL PARAMETRO ENCAMINHADAS
    $api_response->set_endpoint($_GET['endpoint']);
    $params = $_GET;
} elseif ($api_response->get_method() == 'POST') {
    // DEFINE QUAL SERÁ O ENDPPOINTER POST E SETA A VARIAVEL PARAMETRO ENCAMINHADAS
    $api_response->set_endpoint($_POST['endpoint']);
    $params = $_POST;
} // END SET ENDPOINTER

// DEFININDO OS PARAMETROS PARA  A CLASS $api_logic ESTOU DEFININDO PARA A VARIAVEL $PARAMS O VALOR DO ENDPOINT
$api_logic = new api_logic($api_response->get_endpoint(), $params);

//CHECA SE EXISTE O ENDPOINT
if (!$api_logic->endpoint_exists()) {
    $api_response->api_request_error('ERROR: Endpointer Não Existe! Endpointer:' . $api_response->get_endpoint());
} // END CHECK ENDPOINT  

// FAZ O REQUEST DO ENDPOINTER

$result = $api_logic->{$api_response->get_endpoint()}();
$api_response->add_data('data', $result);

$api_response->send_response();
