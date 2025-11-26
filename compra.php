<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");

    $idProduto = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $usuarioRepo = new UsuarioRepositorio($pdo);
    $usuarioLogado = $usuarioRepo->findByEmail($emailUsuario);

    $obraRepo = new ObraRepositorio($pdo);
    $produtoRepo = new ProdutoRepositorio($pdo, $obraRepo);

    $produto = $produtoRepo->findById($idProduto);
    
    $erro = $_GET['erro'] ?? '';
    $novacompra = $_GET['novacompra'] ?? '';

    $outOfStorage = $produto->getQuantidade() == 0;

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

                        <?php if($outOfStorage): ?>
                        class="out"
                        <?php endif;?>
                    >
                </div>

                <?php if($outOfStorage): ?>

                <div class="out-container">
                    <a href="/projeto_web1/catalogoCompra.php">
                        <div class="out-message">
                            <h1>Fora de Estoque</h1>
                            <p>Por Favor compre outra coisa até reabastercermos</p>
                        </div>
                    </a>
                </div>

                <?php endif;?>
                
                <form class="form-produto" action="autenticarCompra.php" method="post">

                    <?php if($novacompra == 'true'):?>
                        <p class="mensagem-ok">Compra efetuada com sucesso!</p>
                    <?php elseif($erro == 'zerado'):?>
                        <p class="mensagem-erro">Produto fora de Estoque.</p>
                    <?php elseif($erro == 'saldo'):?>
                        <p class="mensagem-erro">O Usuário não possui saldo suficiente.</p>
                    <?php elseif($erro == 'campos'):?>
                        <p class="mensagem-erro">Selecione uma quanitdade!</p>
                    <?php elseif($erro == 'quantidade'):?>
                        <p class="mensagem-erro">Escolha uma quanitdade válida!.</p>
                    <?php elseif($erro == 'desconhecido'):?>
                        <p class="mensagem-erro">Erro Desconhecido.</p>
                    <?php endif;?>

                    <h1><?= htmlspecialchars($produto->getNome())?></h1>
                    
                    <div class="caracteproduto">
                        <label>Preço</label>
                        <input disabled value="R$ <?=number_format($produto->getPreco(), 2, ",", ".")?>">
                    </div>
                    <div class="caracteproduto">
                        <label>Saldo Usuário</label>
                        <input disabled value="R$ <?= number_format($usuarioLogado->getSaldo(), 2, ",", ".")?>">
                    </div>
                    <div class="caracteproduto">
                        <label>Quantidade Estoque</label>
                        <input disabled type="number" name="quantidade_estoque" id="qtdEstoque" value="<?= htmlspecialchars($produto->getQuantidade())?>">
                    </div>
                    <div class="caracteproduto">
                        <label for="qtdDesejada">Quantidade Desejada</label>
                        <input 
                            type="number" 
                            name="quantidade_desejada"
                            id="qtdDesejada" 
                            value="" 
                            max="<?= htmlspecialchars($produto->getQuantidade())?>" 
                            min="1"

                            <?php if($outOfStorage) echo("disabled");?>
                        >
                    </div>
                    
                    <input type="hidden" name="preco_unitario" id="precoUnitario" value="<?=htmlspecialchars($produto->getPreco()) ?>">
                    <input disabled type="text" id="precoTotalAparente" value="">
                    <input type="hidden" name="preco_total" id="precoTotalHidden" value="">

                    <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto->getId())?>">
                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuarioLogado->getId())?>">

                    <button type="submit" <?php if($outOfStorage) echo("disabled");?>>Comprar</button>

                </form>

            </div>

            <div class="container-inferior">
                
                <label>Descrição Produto:</label>
                <p><?= htmlspecialchars($produto->getDescricao())?></p>

            </div>

        </section>
    
    </main>

    <script src="js/form.js">
    </script>
    
    <script>

        let qtdDesejada = document.getElementById("qtdDesejada");
        let qtdEstoque = document.getElementById("qtdEstoque");
        let precoUnitario = document.getElementById("precoUnitario");
        let precoTotalHid = document.getElementById("precoTotalHidden");
        let precoTotalApr = document.getElementById("precoTotalAparente");

        function formatarPreco(valor) {
            return new Intl.NumberFormat("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(valor);
        }

        function calcular() {

            let numero1 = Number(qtdDesejada.value);
            let numero2 = Number(precoUnitario.value);

            if (numero1 <= Number(qtdEstoque.value)) {

                let resultado = numero1 * numero2;

                precoTotalApr.value = "R$ " + formatarPreco(resultado); 
                precoTotalHid.value = resultado;
                
            }
            else {

                precoTotalApr.value = "R$ " + formatarPreco(0); 
                precoTotalHid.value = 0;
            }
        }

        qtdDesejada.addEventListener("input", calcular);

    </script>

    
</body>
</html>