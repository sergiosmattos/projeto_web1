<?php
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require __DIR__.'/src/repositorio/UsuarioRepositorio.php';

    $usuarioRepo = new UsuarioRepositorio($pdo);

    session_start();

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

    if ( !$aceito ) {

        header('Location: converterMoeda.php?confirmacao=false');
        exit;

    }

    $emailUsuario = $_SESSION['usuario'] ?? '';

    $usuario = $usuarioRepo->findByEmail($emailUsuario);
    $usuario->setSaldo($usuario->getSaldo() + (float) $saldo);
    $usuarioRepo->atualizar($usuario);

    header('Location: converterMoeda.php?confirmacao=true');
    exit;

?>