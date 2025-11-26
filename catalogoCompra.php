<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

    $produtoRepositorio = new ProdutoRepositorio($pdo, new ObraRepositorio($pdo));
    $produtosDestaque = $produtoRepositorio->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/catalogo.css">
    <title>Geek Artifacts</title>
    
</head>
<body>

    <?php include_once(DIR_PROJETOWEB."reutilizar/header.php"); ?>
    
    <main>

        <div class="container-banner">

            <div class="container-titulo">
                <h2>Produtos</h2>
            </div>

        </div>

        <div class="container-classificar">
            
        </div>

        <div class="produtos-itens">

            <?php if (empty($produtosDestaque)): ?>
                <p>Nenhum produto disponível no momento.</p>
            <?php else: ?>

                <?php foreach ($produtosDestaque as $produto): ?>

                    <?php if($produto->getQuantidade() > 0):?>
                    <?php include(DIR_PROJETOWEB."/reutilizar/card-produto.php"); ?>
                    <?php endif;?>

                <?php endforeach; ?>
                
            <?php endif; ?>

        </div>

    </main>

</body>
</html>