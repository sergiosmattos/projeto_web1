<?php

    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    require_once __DIR__ . '/../../../src/Repositorio/ObraRepositorio.php';

    $obraRepositorio = new ObraRepositorio($pdo);

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $modoEdicao = false;
    $obra = null;

    if ($id) {

        if (method_exists($obraRepositorio, 'findById')) {
            
            $obra = $obraRepositorio->findById($id);
            var_dump($obra);

        }

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


    $tituloPagina = $modoEdicao ? 'Editar Obra' : 'Cadastrar Obra';
    $textoBotao   = $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Obra';
    $actionForm   = $modoEdicao ? 'salvar.php' : 'salvar.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_geek.png">
    <link rel="stylesheet" href="../../css/reset.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/form.css">
    <title>Gerenciar Obras</title>
</head>

<body>
    
    <?php include_once '../../../header.php' ?>

    <aside class="sidebar">
        <a href="../dashboardAdmin.html">Painel de controle</a>
        <a href="../Obra/listar.php">Obra</a>
        <a href="#">Usuários</a>
        <a href="#">Leilões</a>
        <a href="#">Categorias</a>
        <a href="#">Produtos</a>
    </aside>

    <section class="all-form">
        <h2>Cadastrar Obra</h2>

        <div class="form-wrapper">
            <form action="salvar.php" method="POST" class="form-cadastro">
                
                <input id="nome" name="nome" type="text" placeholder="Nome" value=<?=$valorNome ?> required>
                <input id="descricao" name="descricao" type="text" placeholder="Descrição" value=<?= $valorDescricao ?> required>

                
                <div class="grupo-botoes">
                    <button type="submit" class="botao-cadastrar">Cadastrar</button>
                    <a href="listar.php" class="botao-voltar">Voltar</a>
                </div>
            </form>
        </div>
    </section>


</body>
</html>
