<?php 
require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/api-functions.php');

// Inicializa uma variável para armazenar a resposta
$response = [];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url']) && !empty($_POST['url'])) {
    // Obtemos a URL do formulário
    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    
    // Faz a requisição à API com a URL fornecida
    $response = api_request('validate_url', 'GET', ['url' => $url]);

    // Verifica se a resposta contém dados e se há links válidos
    if (!isset($response['data']['results']['url']) || !is_array($response['data']['results']['url'])) {
        $response['error'] = 'Nenhum link encontrado ou resposta inválida.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validador de URL</title>
    <link rel="stylesheet" href="css/style-base.css">
   
</head>
<body>

<!-- <?php   function validate_w3c_url($url)
{
    $api_url = 'https://validator.w3.org/nu/?doc=' . urlencode($url) . '&out=json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: PHP-Curl/1.0'
    ]);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return ['status' => false, 'message' => 'cURL error: ' . curl_error($ch)];
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        return ['status' => false, 'message' => ' status code: ' . $http_code];
    }

    // Debugging output
    error_log('Response: ' . $response);

    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['status' => false, 'message' => 'JSON decode error: ' . json_last_error_msg()];
    }

    if (isset($result['messages']) && !empty($result['messages'])) {
        $errors = [];
        $warnings = [];
        foreach ($result['messages'] as $message) {
            if ($message['type'] === 'error') {
                $errors[] = $message['message'];
            } elseif ($message['type'] === 'info' && isset($message['subtype']) && $message['subtype'] === 'warning') {
                $warnings[] = $message['message'];
            }
        }

        if (!empty($errors)) {
            return [
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $errors,
                'warnings' => $warnings
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Validation passed with warnings',
                'warnings' => $warnings
            ];
        }
    }

    return ['status' => true, 'message' => 'Validation passed with no issues'];
}

// Teste da função
$url = "https://www.producao.mpitemporario.com.br/quimiprol.com.br/produtos";
$result = validate_w3c_url($url);
var_dump($result);
 ?> -->
<div class="container">
    <div class="wrapper">
        <h1>Validador de URL</h1>
        <form action="" method="post" class="form">
            <label for="url">URL para validar:</label>
            <input type="text" id="url" name="url" value="<?php echo isset($_POST['url']) ? htmlspecialchars($_POST['url']) : ''; ?>" required>
            <input type="submit" value="Validar">
        </form>
        <?php if (!empty($response)): ?>
            <div class="links">
                <?php if (isset($response['error'])): ?>
                    <p class="error"><?php echo htmlspecialchars($response['error']); ?></p>
                <?php elseif (isset($response['data']['results']['url']) && is_array($response['data']['results']['url'])): ?>
                    <?php foreach ($response['data']['results']['url'] as $link): ?>
                        <div><a target="_blank" rel="nofollow" href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($link); ?></a></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
