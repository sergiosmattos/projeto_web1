<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';
    
    session_start();

    $emailUsuario = $_SESSION['usuario'] ?? null;

    if (!isset($emailUsuario)) {
        header('Location: login.php');
        exit;
    }

    $tipoUsuario = $_SESSION['tipo'] ?? 'User';

    if ($tipoUsuario !== 'Admin') {
        header('Location: dashboardUsuario.php');
        exit;
    }

    $categoriaRepo = new CategoriaRepositorio($pdo);
    $obraRepo = new ObraRepositorio($pdo);
    $obraCategoriaRepo = new ObraCategoriaRepositorio(
        $pdo,
        $obraRepo,
        $categoriaRepo
    );

    $obras = $obraRepo->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/projeto_web1/img/logo_geek.png">
    <link rel="stylesheet" href="/projeto_web1/css/reset.css">
    <link rel="stylesheet" href="/projeto_web1/css/dashboard.css">
    <link rel="stylesheet" href="/projeto_web1/css/listar.css">
    <title>Gerenciar - Obras</title>
</head>

<body>
    
    <?php include_once DIR_PROJETOWEB . '/reutilizar/header.php' ?>

    <?php include DIR_PROJETOWEB . '/reutilizar/asidemenu.php'?>

    <div class="container-listar">

        <h1>Gerenciar Obras</h1>

        <div class="container-topo">

            <a href="form.php"><button class="botao-adicionar">Adicionar Obra</button></a>
            
            <div class="barra-pesquisar">
                <input type="text" placeholder="Pesquisar obra...">
            </div>

        </div>

        <section class="container-tabela">

            <table>
                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Categorias</th>
                        <th>Ações</th>
                    </tr>

                </thead>
                <tbody>

                    <?php foreach ($obras as $obra): ?>
                        <tr>
                            <td><?= htmlspecialchars($obra->getId()) ?></td>
                            <td><?= htmlspecialchars($obra->getNome()) ?></td>
                            <td><?= htmlspecialchars($obra->getDescricao()) ?></td>
                            <td>
                                <ul>

                                    <?php
                                        $relacionamentos = $obraCategoriaRepo->listByObra($obra);
                                        if(isset($relacionamentos)):
                                    ?>

                                    <?php foreach($relacionamentos as $relacionamento): ?>
                                        <li><?=htmlspecialchars($relacionamento->getCategoria()->getNome())?></li>
                                    <?php endforeach; ?>

                                    <?php else: ?>
                                        Nenhuma Categoria
                                    <?php endif;?>

                                </ul>
                            </td>
                            <td>
                                <div class="td-acoes">
                                    <form action="excluir.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars( $obra->getId() ) ?>">
                                        <input type="submit" class="botao-excluir" value="Excluir">
                                    </form>
                                    <form action="form.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars( $obra->getId() ) ?>">
                                        <input type="submit" class="botao-editar" value="Editar">
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </section>
    
    </div>
</body>
</html>
