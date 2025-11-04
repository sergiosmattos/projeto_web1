<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

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

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $usuario = $usuarioRepositorio->findByEmail($emailUsuario);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Geek Artifacts</title>
</head>
<body>

    <?php include_once 'reutilizar/header.php' ?>

    <main>
        
        <?php include_once 'reutilizar/asidemenu.php' ?>

        <section class="container-dashboard">
        
            <img src="img/logo_geek.png" alt="Logo_Geek_Artifacts">
            <h2>Bem-vindo, Admin!</h2>
            <p>Use o menu ao lado para navegar pelas opções de administração.</p>
            <p>ou logo abaixo</p>

            <div class="dashboard-opcoes">

                <a href="#" class="dashboard-option-even">
                    <h2>Usuários</h2>
                    <p>Gerenciar Usuarios</p>
                </a>
        
                <a href="#" class="dashboard-option-odd">
                    <h2>Produtos</h2>
                    <p>Gerenciar Produtos</p>
                </a>
        
                <a href="#" class="dashboard-option-even">
                    <h2>Leilões</h2>
                    <p>Gerenciar Leilões</p>
                </a>
                
                <a href="#" class="dashboard-option-odd">
                    <h2>Obras</h2>
                    <p>Gerenciar Obras</p>
                </a>

                <a href="#" class="dashboard-option-even">
                    <h2>Categorias</h2>
                    <p>Gerenciar Categorias</p>
                </a>

            </div>

        </section>

    </main>
</body>
</html>
