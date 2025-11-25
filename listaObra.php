<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $categoriaRepositorio = new CategoriaRepositorio($pdo);
    $categorias = $categoriaRepositorio->listar();

    $obraRepositorio = new ObraRepositorio($pdo);
    $produtoRepositorio = new ProdutoRepositorio($pdo, $obraRepositorio);
    $produtosDestaque = $produtoRepositorio->listarDestaque(4);

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

    <?php include_once(DIR_PROJETOWEB.'reutilizar/header.php') ?>
    
    <main>

        <div class="categorias-container">

            <h2>- Top Categorias</h2>
            


</div>

    </main>

</body>
</html>