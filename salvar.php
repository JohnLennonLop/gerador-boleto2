<?php
ob_start();
require('./sheep_core/config.php');


require('vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;



$gerar = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(isset($gerar['gerarBoleto'])){
    unset($gerar['gerarBoleto']);
    $ler = new Ler();
    $ler->Leitura('usuarios', "WHERE id = :id", "id={$gerar['id']}");
    if($ler->getResultado()){
      foreach($ler->getResultado() as $cliente);
        $cliente = (object) $cliente;
    }

    $vencimento = date('d/m/Y', strtotime($gerar['data']));

    $cpf = preg_replace('/\W+/u', '', $cliente->cpf);
    //echo "Nome: {$cliente->nome} data: {$vencimento} plano: {$gerar['plano']} valor: {$gerar['valor']}";
   
    
$clientId= 'Client_Id_4377d3cca6e73c40d679df54a010bc569a06547e';
$clientSecret ='Client_Secret_17fb52066418e2a2e5e34c3f7cf40b06e61ec73d';

$options = [
    "client_id" => "$clientId",
    "client_secret" => $clientSecret,
    "sandbox" => false//true = teste, false = produ. 
    
];


    $items =[ [
        'name' => $gerar['plano'],
        'amount' => 1,
        'value' => intval($gerar['valor']),
        ]
    ];

   

    $customer = [
        'name' => $cliente->nome,
        'cpf' => $cpf,
        'email' => $cliente->email
    ];

    $bankingBillet = [
        'expire_at' => $gerar['data'],
        "message" => "Boleto gerado",
        'customer' => $customer,
    ];
    $payment = ['banking_billet' => $bankingBillet];

    $body = [
        "items" => $items,
        "payment" => $payment
    ];

    try {
        $api = new Gerencianet($options);
        $response = $api->createOneStepCharge($params = [], $body);
        
        if (isset($response['data']['charge_id'])) {
            $chargeId = $response['data']['charge_id'];
            $user_id = $gerar['id']; 
        
       
$expire_at = $gerar['data'];

$chargeLink = $response['data']['link'];

$query = "INSERT INTO boletos (charge_id, user_id, expire_at, link) VALUES (?, ?, ?, ?)";

$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param("siss", $chargeId, $user_id, $expire_at, $chargeLink);

    if ($stmt->execute()) {
        header("Location: " . $chargeLink);
    } else {
        echo "Erro ao inserir os dados na tabela de boletos: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $mysqli->error;
}

        } else {
            echo "A criação da cobrança não foi bem-sucedida.";
        }
        
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
    
    

}


?>