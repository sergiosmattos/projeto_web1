<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    if( $tipoUsuario !== 'Admin' ) {
        header('Location: dashboardUsuario.php');
        exit;
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/admin.css">
    <link rel="stylesheet" href="/projeto_web1/css/listar.css">
    <title>Geek Artifacts</title>
</head>
<body>

    <?php include_once DIR_PROJETOWEB . 'header.php' ?>

    <main>
        
        <?php include_once DIR_PROJETOWEB . 'menu-gerenciar.php' ?>

        

    </main>

</body>
</html>
