<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");
    include_once(DIR_PROJETOWEB."/reutilizar/verify-admin.php");

    $obraRepo = new ObraRepositorio($pdo);
    $categoriaRepo = new CategoriaRepositorio($pdo);

    $obraCategoriaRepo = new ObraCategoriaRepositorio($pdo,
        $obraRepo,
        $categoriaRepo
    );

    $categorias = $categoriaRepo->listarPaginado(50, 0, "nome_categoria");

    $erro = $_GET['erro'] ?? [];
    $id = $_POST['id'] ?? null;

    var_dump($erro);

    $modoEdicao = $id ? true : false;

    $obra = $modoEdicao ? $obraRepo->findById($id) : null;

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
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/form.css">
    <title>Gerenciar Obras</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . 'reutilizar/header.php' ?>

    <?php include_once DIR_PROJETOWEB . 'reutilizar/asidemenu.php' ?>

    <section class="all-form">

        <h2><?= $textoTitulo ?></h2>

        <div class="form-wrapper">

            <form action="salvar.php" method="POST" class="form-cadastro" autocomplete="off">

                <div class="container-feedback">
                    <?php if (in_array('campos',$erro)): ?>
                        <p class="mensagem-erro">Preencha todos os campos.</p>
                    <?php endif; ?>
                    <?php if (in_array('selecao',$erro)): ?>
                        <p class="mensagem-erro">Selecione uma categoria.</p>
                    <?php endif; ?>
                </div>

                <input name="id" type="hidden" value=<?= $id ?>>

                <div class="grupo-input">

                    <div>
                        <label>Nome </label>
                        <input name="nome" type="text" value="<?= $valorNome?>">
                    </div>

                    <div>
                        <label>Descrição </label>
                        <textarea name="descricao" spellcheck="false"><?= $valorDescricao?></textarea>
                    </div>

                    <div>
                        <label>Categorias </label>
                        <div class="select-multiple">

                            <?php foreach($categorias as $categoria):?>

                            <label>
                                
                                <?= $categoria->getNome()?>
                                <input type="checkbox" value="<?= $categoria->getId()?>" name="categorias[]" 
                                
                                    <?php
                                    
                                        if( $modoEdicao ) {

                                            $idObra = $id;
                                            $idCategoria = $categoria->getId();
                                            $relacionamento = $obraCategoriaRepo->findById($id, $idCategoria);
                                            
                                            if(isset( $relacionamento )){
                                                echo "checked";
                                            }
                                        
                                        }
                                    ?>
                                >
                            </label>

                            <?php endforeach;?>

                        </div>
                    </div>

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
