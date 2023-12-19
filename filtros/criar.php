<?php

ob_start();
require('../sheep_core/config.php');

$gerarB = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(isset($gerarB['gerarBoleto'])){
    unset($gerarB['gerarBoleto']);

    $salvar = new Usuarios();
    $salvar->CriarUsuario($gerarB);

    if($salvar->getResultado()){
        header("Location: ".HOME."/index.php?sucesso=true");
    }else{ header("Location: ".HOME."/index.php?error=true");
    }
}
?>