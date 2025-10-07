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
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Administração</title>
</head>
<body>
    <section class="topo">
        <div class="logo">
            <img src="img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
            <h1>Geek Artefacts</h1>
        </div>

        <a href="#">Adminstração</a>
        <a href="#">Leilao</a>
        <a href="#">Compra</a>

        <img src="img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>

    <aside class="sidebar">
        <a href="#">Painel de controle</a>
        <a href="painelcontrole/obra/listar.php">Obras</a>
        <a href="#">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>


    <main>
        <img src="img/logo_geek.png" alt="">
        <h2>Bem-vindo, Admin!</h2>
        <p>Use o menu ao lado para navegar pelas opções de administração.</p>
        <p>ou logo abaixo</p>

        <section class="deshboard">
            <a href="#" class="deshboard-produto">
                <h2>Produtos</h2>
                <p>Gerencia produtos</p>
            </a>
    
            <a href="Usuario/listarUsuario.html" class="deshboard-usuario">
                <h2>Usuários</h2>
                <p>Gerenciar Usuarios</p>
            </a>
    
            <a href="" class="deshboard-leilao">
                <h2>Leilões</h2>
                <p>Gerenciar Leilões</p>
            </a>
            
            <a href="#" class="deshboard-cetegoria">
                <h2>Categorias</h2>
                <p>Gerenciar Categorias</p>
            </a>

            <a href="#" class="deshboard-cetegoria">
                <h2>Categorias</h2>
                <p>Gerenciar Categorias</p>
            </a>

        </section>

    </main>
</body>
</html>
