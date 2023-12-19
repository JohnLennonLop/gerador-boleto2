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
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["charge_id"])) {
        $charge_id = $data["charge_id"];

        try {
            $api = new Gerencianet($options);
            $params = ["id" => $charge_id];
            $response = $api->cancelCharge($params);

            if (isset($response['code']) && $response['code'] == 200) {
                echo  "Boleto cancelado com sucesso";
            } else {
                echo  "Erro ao cancelar o boleto";
            }
        } catch (GerencianetException $e) {
            echo json_encode(["error" => $e->error, "code" => $e->code, "description" => $e->errorDescription]);
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
