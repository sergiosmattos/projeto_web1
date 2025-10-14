<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    $obraRepositorio = new ObraRepositorio($pdo);

    $id = $_POST['id'];
    $modoEdicao = false;
    $obra = null;

    if ($id) {

        $obra = $obraRepositorio->findById($id);

        if ($obra) {

            $modoEdicao = true;
        } 
        else {

            header('Location: listar.php');
            exit;

        }
    }

    $valorNome = $modoEdicao ? $obra->getNome() : '';
    $valorDescricao = $modoEdicao ? $obra->getDescricao() : '';

    $textoTitulo = $modoEdicao ? 'Editar Obra' : 'Cadastrar Obra';
    $textoBotao = $modoEdicao ? 'Editar' : 'Cadastrar';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/form.css">
    <title>Gerenciar Obras</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . '/header.php' ?>

    <?php include_once DIR_PROJETOWEB . '/menu-gerenciar.php' ?>

    <section class="all-form">

        <h2><?= $textoTitulo ?></h2>

        <div class="form-wrapper">

            <form action="salvar.php" method="POST" class="form-cadastro">
                
                <input name="id" type="hidden" value=<?= $id ?>>
                <input id="nome" name="nome" type="text" placeholder="Nome" value=<?= $valorNome ?>>
                <input id="descricao" name="descricao" type="text" placeholder="Descrição" value=<?= $valorDescricao?>>
                
                <div class="grupo-botoes">
                    <button type="submit" class="botao-cadastrar"><?= $textoBotao ?></button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>

            </form>
        </div>

    </section>


</body>
</html>
