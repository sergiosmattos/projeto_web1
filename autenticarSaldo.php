<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header('Location: converterMoeda.php');
        exit;
    }

    $saldo = $_POST['saldo_pedido'] ?? '';

    if ( $saldo == '' ) {

        header('Location: converterMoeda.php?erro=campos');
        exit;

    }

    $aceito = true;

?>