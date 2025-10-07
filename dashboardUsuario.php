<?php

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Dashboard</title>
</head>
<body>
    <section class="topo">
        
        <div class="logo">
            <a href="dashboardUsuario.php">
                <img src="img/logo_geek.png" class="iconLogo" alt="logo geek artefacts">
                <h1>Geek Artifacts</h1>    
            </a>
        </div>

        <div class="container-navegacao">

            <?php if($tipoUsuario === 'Admin'): ?>
            <a href="dashboardAdmin.php">Adminstração</a>
            <?php endif?>

            <a href="#">Leilao</a>
            <a href="#">Compra</a>
        </div>
        
        <img src="img/icon_user_branco.svg" class="iconUser" alt="IconUsuario">
    </section>
</body>
</html>