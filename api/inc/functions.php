<?php
function getLinks($dominio) {
    $url = "https://www.producao.mpitemporario.com.br/{$dominio}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $html = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo'Erro cURL: ' . curl_error($ch);
        return [];
    }
    
    curl_close($ch);

    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();

    $links = $dom->getElementsByTagName('a');

    $linkArray = [];

    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $hrefArray = explode("/",  $href);
        if (strpos($href, $url) !== false) {
            if (!empty($href) && strpos($href, '#') !== 0) {
                $linkArray[] = $href;
            }
        }
    }

    return$linkArray;
}

?>