<?php
ob_start();
require('./sheep_core/config.php');

require('vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;




?>
<!DOCTYPE html>
<html lang="pt-br" >
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>TEste</title>
        <link rel="stylesheet" href="assets/css/app.min.css">
      
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- FIM DO CSS  SHEEP FRAMEWORK PHP - MAYKONSILVEIRA.COM.BR -->
</head>
<body>


<!-- Main Content -->
<div align="center" style="padding:20px; margin-top:120px;" >
 
        <div class="col-md-10"> 
      <section class="section" >


            <!-- inicio topo menu -->
            <?php
            
            require_once('topo.php');

            ?>
      
            <!-- fim topo menu -->


           <br>
      
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Ativos</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
            <thead>
              <tr>
              
                <th>Nome</th>
                <th>CPF</th>
                <th>Boletos</th> 
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
      <?php
                
$clientId= 'Client_Id_4377d3cca6e73c40d679df54a010bc569a06547e';
$clientSecret ='Client_Secret_17fb52066418e2a2e5e34c3f7cf40b06e61ec73d';

$options = [
    "client_id" => "$clientId",
    "client_secret" => $clientSecret,
    "sandbox" => false//true = teste, false = produ. 
    
];



$ler = new Ler();
$ler->Leitura('usuarios', "ORDER BY data DESC");
if ($ler->getResultado()) {
    foreach ($ler->getResultado() as $cliente) {
        $cliente = (object) $cliente;
?>
        <tr>
            <td><?= $cliente->nome ?></td>
            <td><?= $cliente->cpf ?></td>
            <td>
                
            <?php
$boletos = new Ler();
$boletos->Leitura('boletos', "WHERE user_id = :user_id", "user_id={$cliente->id}");

if ($boletos->getResultado()) {
    foreach ($boletos->getResultado() as $boleto) {
        $boletoId = $boleto['charge_id'];
        $status = '';

        $params = [
            "id" => $boletoId
        ];

        try {
            $api = new Gerencianet($options);
            $response = $api->detailCharge($params);

            if (isset($response['data']['status'])) {
                $status = $response['data']['status'];
            }
        } catch (GerencianetException $e) {
        } catch (Exception $e) {
        }
?>
 <tr>
    <td><?= $cliente->nome ?></td>
    <td><?= $cliente->cpf ?></td>
    <td><a href="<?= $boleto['link'] ?>" target="_blank"><?= $boletoId ?></a></td>  
      <td><?= $status ?></td>
    <td>
    <a href="editar-boleto.php?charge_id=<?= $boletoId ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i> Editar</a>
</td>
<td>
<a href="#" onclick="cancelarBoleto(<?= $boletoId ?>)" class="btn btn-icon btn-primary"><i class="far fa-edit"></i> cancelar</a>
</td>
<td>
    <a href="historico-boleto.php?charge_id=<?= $boletoId ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i> historico</a>
</td>

    </td>
    
    
</tr>


<?php
    }
} else {
    echo "Nenhum boleto encontrado.";
}
?>

            </td>
        </tr>
        <?php
    }
}
?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

            </div>
          
      </section>
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>
  <script>
$(document).ready(function() {
    $(".datepicker-input").datepicker({
        dateFormat: 'yyyy-mm-dd', // Formato da data
        changeMonth: true,
        changeYear: true,
        yearRange: "c-100:c+100", // Intervalo de anos (opcional)
        onSelect: function(selectedDate) {
            // Quando o usuário seleciona uma data, preencha o campo new_expire_at
            $(this).closest("tr").find(".new_expire_at").val(selectedDate);
        }
    });

    // Manipula o clique no botão de edição
    $(".edit-button").on("click", function() {
        var row = $(this).closest("tr");
        var datepickerInput = row.find(".datepicker-input");

        // Abre o Datepicker ao clicar no botão de edição
        datepickerInput.datepicker("show");
    });
});
</script>

<script>
function cancelarBoleto(chargeId) {
    var xhr = new XMLHttpRequest();
    xhr.open("PUT", "cancelar-boleto.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onload = function () {
        if (xhr.status === 200) {
            // A solicitação PUT foi bem-sucedida
            console.log("Boleto cancelado com sucesso.");
            // Você pode adicionar uma mensagem ao usuário ou redirecioná-lo para a página apropriada
        } else {
            // A solicitação PUT não foi bem-sucedida
            console.error("Erro ao cancelar o boleto: " + xhr.status);
            // Você pode adicionar mensagens de erro ou lidar com o erro de acordo com suas necessidades
        }
    };

    var data = JSON.stringify({ charge_id: chargeId });
    xhr.send(data);
}
</script>

  

</body>
</html>

<?php
ob_end_flush();
?>