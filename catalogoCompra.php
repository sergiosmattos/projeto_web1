<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $produtoRepositorio = new ProdutoRepositorio($pdo, new ObraRepositorio($pdo));
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

        <div class="produtos-container">

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

</div>

    </main>

</body>
</html>