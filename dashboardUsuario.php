<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';



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

    <?php include_once 'reutilizar/header.php' ?>
    
    <main>

        <div class="categorias-container">

            <h2>- Top Categorias</h2>
            
            <div class="categorias-itens">
                
                <?php foreach ($categorias as $categoria): ?>
                    <a href="#" class="categoria-item">
                        <img 
                            src="/projeto_web1/<?= htmlspecialchars($categoria->getImagemDiretorio()) ?>" 
                            alt="<?= htmlspecialchars($categoria->getNome()) ?>"
                            class="imagemList">
                        <p><?= htmlspecialchars($categoria->getNome()) ?></p>
                    </a>
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
                        <div class="produto-card">
                            <a href="#">
                                <img 
                                src="/projeto_web1/<?= htmlspecialchars($produto->getImagemDiretorio()) ?>" 
                                alt="<?= htmlspecialchars($produto->getNome()) ?>">
                                <h3><?= htmlspecialchars($produto->getNome()) ?></h3>
                                <p class="descricao"><?= htmlspecialchars($produto->getDescricao()) ?></p>
                                <p class="preco">R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></p>
                                
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <a href="#" class="botao-mais">VER MAIS</a>

        </div>

</div>

    </main>

</body>
</html>