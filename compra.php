<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;
    $confirmacao = $_GET['editadoregistro'] ?? false;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $idProduto = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $obraRepo = new ObraRepositorio($pdo);
    $produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);

    $produto = $produtoRepo->findById($idProduto);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/mensagem.css">
    <link rel="stylesheet" href="css/compra.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Granato B</title>
</head>
<body>
    
    <?php include_once(DIR_PROJETOWEB.'/reutilizar/header.php'); ?>

    <main>

        <section class="container-compra">

            <div class="container-superior">

                <img 
                    src="/projeto_web1/<?=htmlspecialchars($produto->getImagemDiretorio())?>" 
                    alt="<?=htmlspecialchars($produto->getNome())?>"
                >
                
                <form class="form-produto">

                    <div class="informacoes-compra">

                        <h2><?=htmlspecialchars($produto->getNome())?></h2>
                        
                        <div>
                            <div>R$ <?=number_format($produto->getPreco(), 2,",", ".")?></div>
                        </div>

                    </div>

                    <div class="informacoes-produto">

                        <div>
                            <label>Obra:</label>
                            <div><?=$produto->getObra()->getNome()?></div>
                        </div>

                        <div>
                            <label>Obra:</label>
                            <div><?=$produto->getObra()->getNome()?></div>
                        </div>

                    </div>

                </form>

            </div>

            <div class="container-inferior">
                
                <label>Descrição Produto:</label>
                <p><?= htmlspecialchars($produto->getDescricao())?></p>

            </div>

        </section>
    
    </main>

    <script scr="js/form.js"></script>
    <script>



    </script>
    
</body>
</html>