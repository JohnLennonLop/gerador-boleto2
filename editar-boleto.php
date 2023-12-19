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
    "sandbox" => false//true = teste, false = produ. 
    
];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $charge_id = $_POST["charge_id"];
    $new_expire_at = $_POST["new_expire_at"];
	
    // Crie os parâmetros e o corpo da requisição para atualizar o boleto
    $params = [
        "id" => $charge_id
    ];

    $body = [
        "expire_at" => $new_expire_at
    ];

    try {
        $api = new Gerencianet($options);
        $response = $api->updateBillet($params, $body); // O terceiro parâmetro é para especificar que é uma requisição PUT

        // Verifique a resposta da API e redirecione o usuário de volta à página da tabela
        if (isset($response['code']) && $response['code'] == 200) {
            header("Location: listar-boletos.php"); // Redirecione para a página da tabela
        } else {
            echo "Erro ao atualizar o boleto: " . $response['code'] . " - " . $response['error'];
        }
    } catch (GerencianetException $e) {
        echo $e->code;
        echo $e->error;
        echo $e->errorDescription;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Editar Boleto</h1>
    <!-- Formulário para edição do boleto -->
    <form action="" method="post">
        <input type="hidden" name="charge_id" value="<?= $_GET['charge_id'] ?>">
        <input type="text" name="new_expire_at" placeholder="Nova data de vencimento" required>
        <button type="submit">Atualizar Boleto</button>
    </form>
</body>
</html>