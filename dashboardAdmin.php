<?php

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
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Geek Artifacts</title>
</head>
<body>

    <?php include_once 'header.php' ?>

    <main>
        
        <?php include_once 'menu-gerenciar.php' ?>

        <img src="img/logo_geek.png" alt="">
        <h2>Bem-vindo, Admin!</h2>
        <p>Use o menu ao lado para navegar pelas opções de administração.</p>
        <p>ou logo abaixo</p>

        <section class="dashboard">

            <a href="#" class="dashboard-option-even">
                <h2>Produtos</h2>
                <p>Gerencia produtos</p>
            </a>
    
            <a href="Usuario/listarUsuario.html" class="dashboard-option-odd">
                <h2>Usuários</h2>
                <p>Gerenciar Usuarios</p>
            </a>
    
            <a href="" class="dashboard-option-even">
                <h2>Leilões</h2>
                <p>Gerenciar Leilões</p>
            </a>
            
            <a href="#" class="dashboard-option-odd">
                <h2>Categorias</h2>
                <p>Gerenciar Categorias</p>
            </a>

            <a href="#" class="dashboard-option-even">
                <h2>Categorias</h2>
                <p>Gerenciar Categorias</p>
            </a>

        </section>

    </main>
</body>
</html>
