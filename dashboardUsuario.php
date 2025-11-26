<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

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
            
            <div class="categorias-itens">
                
                <?php foreach ($categorias as $categoria): ?>
                    <?php include(DIR_PROJETOWEB."/reutilizar/card-categoria.php");?>
                <?php endforeach; ?>

            </div>

        </div>

        <div class="produtos-container">

            <h2>- Top produtos mais cobiçados</h2>

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

            <a href="catalogoCompra.php" class="botao-mais">VER MAIS</a>

        </div>

</div>

    </main>

</body>
</html>