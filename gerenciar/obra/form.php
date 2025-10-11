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

    $obraRepositorio = new ObraRepositorio($pdo);
    $obras = $obraRepositorio->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/listar.css">
    <link rel="stylesheet" href="/projeto_web1/css/admin.css">
    <title>Gerenciar - Obras</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . 'header.php' ?>

    <?php include DIR_PROJETOWEB . 'menu-gerenciar.php'?>

    <div class="all-form">

        <h1>Cadastrar Obras</h1>

        <div class="topo-listar">

            <a href="form.php"><button class="botao-adicionar">Adicionar Obra</button></a>
            
            <div class="barra-pesquisar">
                <input type="text" placeholder="Pesquisar obra...">
            </div>

        </div>
    
    </div>
</body>
</html>
