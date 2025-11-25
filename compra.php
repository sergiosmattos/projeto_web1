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

    $usuarioRepo = new UsuarioRepositorio($pdo);

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

                <div class="imagem">
                    <img 
                        src="/projeto_web1/<?=htmlspecialchars($produto->getImagemDiretorio())?>" 
                        alt="<?=htmlspecialchars($produto->getNome())?>"
                    >
                </div>
                
                <div class="relatorioProduto">
                    <form class="form-produto" action="autenticarCompra.php">

                        <div class="superior">
                            <h1><?= htmlspecialchars($produto->getNome())?></h1>
                            
    
                            <input readonly class="precoProduto"readonly type="text" name="preco_unitario" value="R$ <?= number_format($produto->getPreco(), 2, ",", ".")?>">
        
    
                            <div class="caracteproduto">
                                <label>QTD em Estoque</label>
                                <input  readonly type="number" class="bloqueado" name="quantidade_estoque" value="<?= htmlspecialchars($produto->getQuantidade())?>">
                            </div>
                        </div>
    

                        <div class="caracteproduto">
                            <label>QTD Desejada</label>
                            <input type="number" name="quantidade_desejada" value="">
                        </div>

                        <div class="caracteproduto">
                            <label>Valor Total</label>
                            <input readonly type="text" class="bloqueado" name="preco_total_aparente" value="">
                        </div>


                        <div class="caracteproduto">
                            <label>Saldo Usuário</label>
                            <input readonly type="text" class="bloqueado"name="saldo_usuario" value="<?= number_format($usuarioRepo->findByEmail($emailUsuario)->getSaldo(), 2, ",", ".")?>">
                        </div>
    
                        <button type="submit">Comprar</button>
    
                    </form>
                </div>

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