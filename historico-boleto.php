<?php
ob_start();
require('./sheep_core/config.php');
require('vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId= 'Client_Id_4377d3cca6e73c40d679df54a010bc569a06547e';
$clientSecret ='Client_Secret_17fb52066418e2a2e5e34c3f7cf40b06e61ec73d';

$options = [
    "client_id" => "$clientId",
    "client_secret" => $clientSecret,
    "sandbox" => false // true = teste, false = produ.
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Histórico da Cobrança</title>
</head>
<body>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["charge_id"])) {
        $charge_id = $_GET["charge_id"];

        $params = [
            "id" => $charge_id
        ];


  

    try {
        $api = new Gerencianet($options);
        $response = $api->detailCharge($params);
    //var_dump($response); exit;
        if (isset($response['code']) && $response['code'] == 200) {
            // Aqui, você pode acessar o campo "history" e suas mensagens
            if (isset($response['data']['history'])) {
                $history = $response['data']['history'];
                echo "<h1>Histórico da Cobrança</h1>";
    
                // Itere sobre as mensagens do histórico
                foreach ($history as $entry) {
                    echo "<p><strong>Mensagem:</strong> " . $entry['message'] . "</p>";
                    echo "<p><strong>Data:</strong> " . $entry['created_at'] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "Nenhuma mensagem de histórico encontrada para a cobrança.";
            }
        } else {
            // Lide com erros, se necessário
            echo "Erro ao obter informações da transação: " . $response['code'] . " - " . $response['error'];
        }
    } catch (GerencianetException $e) {
        echo $e->code;
        echo $e->error;
        echo $e->errorDescription;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
}