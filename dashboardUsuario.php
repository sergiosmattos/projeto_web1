<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';



    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $categoriaRepositorio = new CategoriaRepositorio($pdo);
    $categorias = $categoriaRepositorio->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <title>Geek Artifacts</title>
    
</head>
<body>

    <?php include_once 'reutilizar/header.php' ?>
    
    <main>

        <div class="categorias-container">

            <h2> - Top Categorias</h2>
            
            <div class="categorias-itens">
                
                <?php foreach ($categorias as $categoria): ?>
                    <p><?= htmlspecialchars($categoria->getNome()) ?></p>
                <?php endforeach; ?>

            </div>

        </div>
    </main>

</body>
</html>