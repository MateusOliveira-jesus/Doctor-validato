<?php

// CLASSES PARA RESPOSTAS DA APi
class api_response
{
    // ARMAZENA OS DADOS DA API
    private  $array ;
    private  $data ;
    //METHOD PRMITIDOS
    private $varMethod = ['GET', 'POST'];
    // PARAMETROS DA URL PERMITIDOS
    private $permited = [".com", ".br"];
    // PARAMETROS DA URL NÃO PERMITIDOS
    private $noPermited = ["/", "https:"];
    //CONSTRUTOR DA CLASS
    public function __construct($array)
    {$this->array;
        $this->data = [];
    } //END CONSTRUCT

    public function check_method($method)
    {
        //CHECANDO SE CONTÉM O METHOD NO ARRAY DE METHODOS PERMITIDOS
        return in_array($method, $this->varMethod);
    } // END CHECK_METHOD

    public function set_method($mehtod)
    {
        //DEFININDO QUAL É O METHOD DO DATA
        $this->data['method'] = $mehtod;
    } //END SET METHOD

    public function get_method()
    {
        //RETORNO DO METHOD
        return $this->data['method'];
    } // END GET METHOD 
    public function set_endpoint($endpoit)
    {
        //SETA E RETORNA O ENDPOINTER
        return $this->data['endpoint'] = $endpoit;
    } // END SET ENDPOINT
    public function get_endpoint()
    {
        //RETORNA O ENDPOINTER
        return $this->data['endpoint'];
    } //END GET ENDPOINT

    public function api_request_error($mensagem = '')
    {
        $data = [
            'status' => 'ERROR',
            'mensagem' => $mensagem,
            'results' => null,
        ];
        //DEFININDO A MENSAGEM DE ERROR
        $this->data['data'] = $data;
        $this->send_response();
    } //END API ERROR

    public function api_send_status($mensagem = '')
    {
        $this->data['status'] = 'SUCCESS';
        $this->data['sucess_mensagem'] = $mensagem;
        $this->send_response();
    } // END SEND STATUS

    public function send_response()
    {
        //DEFININDO A RESPOSTA PARA O SERVIDOR
        header('Content-type:application/json');
        echo json_encode($this->data);
        die(1);
    } //END SEND RESPONSE
    public function add_data($key, $value)
    {
        // DEFINE NO ARRAY DADA O INDICE E O VALOR PASSADO NA FUNÇÃO
        $this->data[$key] = $value;
    } //END SET DATA
    function check_url($url)
    {
        if (!in_array($url, $this->permited) && in_array($url, $this->noPermited)) {
            return false;
        }elseif(in_array($url, $this->permited) && !in_array($url, $this->noPermited)){
            return true;
        }else{
            return false;
        }
        
    }// END CHECK URL
    function api_set_url($url)
    {
        $this->data['url'] = $url;
    } // END SET URL
    function api_get_url()
    {
        return $this->data['url'];
    } // END GET URL

} //END CLASS API