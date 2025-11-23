<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $categoriaRepositorio = new CategoriaRepositorio($pdo);

    $erro = $_GET['erro'] ?? '';
    $id = $_POST['id'] ?? null;

    var_dump($id);

    $modoEdicao = $id ? true : false;

    $categoria = $modoEdicao ? $categoriaRepositorio->findById($id) : null;

    $valorNome = $modoEdicao ? $categoria->getNome() : '';

    $textoTitulo = $modoEdicao ? 'Editar Categoria' : 'Cadastrar Categoria';
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
    <title>Gerenciar Categorias</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . 'reutilizar/header.php' ?>

    <?php include_once DIR_PROJETOWEB . 'reutilizar/asidemenu.php' ?>

    <section class="all-form">

        <h2><?= $textoTitulo ?></h2>

        <div class="form-wrapper">

            <form action="salvar.php" method="POST" class="form-cadastro" autocomplete="off">

                <?php if ($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos!</p>
                <?php endif; ?>

                <input name="id" type="hidden" value=<?= $id ?>>

                <div class="grupo-input">

                    <div>
                        <label>Nome </label>
                        <input name="nome" type="text" value="<?= $valorNome?>">
                    </div>

                </div>

                <div>
                        <label for="imagem">Imagem do produto</label>
                        <input id="imagem" name="imagem" type="file" accept="image/*">
                </div>
                
                <div class="grupo-botoes">
                    <button type="submit" class="botao-executar"><?= $textoBotao ?></button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>

            </form>
        </div>

    </section>

    <script src="/projeto_web1/js/form.js"></script>

</body>
</html>
