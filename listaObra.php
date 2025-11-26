<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

    $idCategoria = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $categoriaRepo = new CategoriaRepositorio($pdo);
    $obraRepo = new ObraRepositorio($pdo);

    $produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);
    $obraCategoriaRepo = new ObraCategoriaRepositorio($pdo, $obraRepo, $categoriaRepo);
    
    $categoriaSelecionada = $categoriaRepo->findById($idCategoria);
    $categorias = $categoriaRepo->listar();

    $obrasCategorias = $obraCategoriaRepo->listByCategoria($categoriaSelecionada);

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

    <?php include_once(DIR_PROJETOWEB.'reutilizar/header.php') ?>
    
    <main>

        <div class="categorias-container">
            
            <div class="categorias-itens">
                
                <?php foreach ($categorias as $categoria): ?>
                    <?php include(DIR_PROJETOWEB."/reutilizar/card-categoria.php");?>
                <?php endforeach; ?>

            </div>

        </div>

        <h2 class="titulo-cat-pag">Mostrando obras relacionadas a:</h2>

        <div class="container-categoria-pag">

            <img 
                src="/projeto_web1/<?= htmlspecialchars($categoriaSelecionada->getImagemDiretorio()) ?>" 
                alt="<?= htmlspecialchars($categoriaSelecionada->getNome()) ?>"
                class="imagemList"
            >

            <h1><?= htmlspecialchars($categoriaSelecionada->getNome()) ?></h1>

        </div>
        
        <div class="container-obra">

            <ul>

                <?php foreach($obrasCategorias as $objeto):?>
                    <li><?=$objeto->getObra()->getNome()?></li>
                <?php endforeach;?>

            </ul>

        </div>

    </main>

</body>
</html>