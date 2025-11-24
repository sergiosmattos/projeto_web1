<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

session_start();

$emailUsuario = $_SESSION['usuario'] ?? null;

if (!isset($emailUsuario)) {
    header('Location: login.php');
    exit;
}

$tipoUsuario = $_SESSION['tipo'] ?? 'User';

$obraRepo = new ObraRepositorio($pdo);
$produtoRepositorio = new ProdutoRepositorio($pdo, $obraRepo);

$erro = $_GET['erro'] ?? '';
$id = $_POST['id'] ?? null;

$modoEdicao = $id ? true : false;

$produto = null;
if ($modoEdicao && $id) {
    $produto = $produtoRepositorio->findById($id);
}

$valorNome = $produto ? $produto->getNome() : '';
$valorDescricao = $produto ? $produto->getDescricao() : '';
$valorPreco = $produto ? $produto->getPreco() : '';
$valorIdObra = $produto ? $produto->getObra()->getId() : '';
$valorImagem = $produto ? $produto->getImagem() : '';

$obras = $obraRepo->listar();

$textoTitulo = $modoEdicao ? 'Editar Produto' : 'Cadastrar Produto';
$textoBotao = $modoEdicao ? 'Editar' : 'Cadastrar';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/form.css">
    <title>Gerenciar Produtos</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . 'reutilizar/header.php' ?>
    <?php include_once DIR_PROJETOWEB . 'reutilizar/asidemenu.php' ?>

    <section class="all-form">

        <h2><?= $textoTitulo ?></h2>

        <div class="form-wrapper">

            <form action="salvar.php" method="POST" enctype="multipart/form-data" class="form-cadastro" autocomplete="off">

                <?php if ($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos!</p>
                <?php endif; ?>

                <input name="id" type="hidden" value="<?= $id ?>">

                <div class="grupo-input">

                    <div>
                        <label>Nome</label>
                        <input name="nome" type="text" value="<?= $valorNome ?>">
                    </div>

                    <div>
                        <label>Descrição</label>
                        <textarea name="descricao"><?= $valorDescricao ?></textarea>
                    </div>

                    <div>
                        <label>Quantidade</label>
                        <input name="quantidade" type="number" step="1" value="<?= $valorQuantidade ?>">
                    </div>

                    <div>
                        <label>Preço</label>
                        <input name="preco" type="number" step="0.01" value="<?= $valorPreco ?>">
                    </div>

                    <div>

                        <label for="obra">Obra</label>
                        <select name="id_obra" id="obra">
                            <option value="" hidden>Selecione uma obra</option>

                            <?php foreach ($obras as $obra): ?>
                                <option 
                                    value="<?= htmlspecialchars($obra->getId()) ?>"
                                    <?= isset($valorIdObra) && $valorIdObra == $obra->getId() ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars($obra->getNome()) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div>
                        <label for="imagem">Imagem do produto</label>
                        <input id="imagem" name="imagem" type="file" accept="image/*">
                    </div>

                </div>

                <div class="grupo-botoes">
                    <button type="submit" class="botao-executar"><?= $textoBotao ?></button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>

            </form>
        </div>

    </section>

</body>
</html>
