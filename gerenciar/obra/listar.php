<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';
    require DIR_PROJETOWEB . 'src/repositorio/ObraCategoriaRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");
    include_once(DIR_PROJETOWEB."/reutilizar/verify-admin.php");

    $categoriaRepo = new CategoriaRepositorio($pdo);
    $obraRepo = new ObraRepositorio($pdo);
    $obraCategoriaRepo = new ObraCategoriaRepositorio(
        $pdo,
        $obraRepo,
        $categoriaRepo
    );

    // Paginação
    $itens_por_pagina = $_GET['itens'] ?? 10;
    $pagina_atual = $_GET['pagina'] ?? 1;
    $offset = ($pagina_atual - 1) * $itens_por_pagina;

    // Ordenação
    $ordem = $_GET['ordem'] ?? null;
    $direcao = $_GET['direcao'] ?? 'ASC';

    // Buscar dados
    $total_obras = $obraRepo->contarTotal();
    $total_paginas = ceil($total_obras / $itens_por_pagina);
    $obras = $obraRepo->listarPaginado($itens_por_pagina, $offset, $ordem, $direcao);

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

            <div class="numero-paginacao">
                <!-- itens por pagina -->
                <form method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <label>Itens por página:</label>
                    <select name="itens" onchange="this.form.submit()" style="padding: 5px;">
                        <option value="5" <?= $itens_por_pagina == 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $itens_por_pagina == 10 ? 'selected' : '' ?>>10</option>
                        <option value="20" <?= $itens_por_pagina == 20 ? 'selected' : '' ?>>20</option>
                        <option value="50" <?= $itens_por_pagina == 50 ? 'selected' : '' ?>>50</option>
                    </select>
                </form>
            </div>

            <table>
                <thead>

                    <tr>
                        <th>ID</th>
                        <th>
                            <div class="nomeColuna">
                                <a href="?ordem=nome_obra&direcao=<?= $ordem == 'nome_obra' && $direcao == 'ASC' ? 'DESC' : 'ASC' ?>&itens=<?= $itens_por_pagina ?>">
                                Nome ⟳
                                <?php if($ordem == 'nome_obra'): ?>
                                    <?= $direcao == 'ASC' ? '⭡A' : '⭣Z' ?>
                                <?php endif; ?>
                                </a>
                            </div>
                        </th>
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

            <div class="container-paginacao">
                <!-- Paginação -->
                <?php if ($total_paginas > 1): ?>
                    <div class="container-paginacao">
                        <p >
                            Página <?= $pagina_atual ?> de <?= $total_paginas ?> (Total: <?= $total_obras ?> obras)
                        </p>
                        
                        <div class="paginacao">
                            <!-- Anterior -->
                            <?php if ($pagina_atual > 1): ?>
                                <a href="?pagina=<?= $pagina_atual - 1 ?>&itens=<?= $itens_por_pagina ?>&ordem=<?= $ordem ?>&direcao=<?= $direcao ?>">◀ Anterior</a>
                            <?php endif; ?>

                            <!-- Números -->
                            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                <?php if ($i == $pagina_atual): ?>
                                    <strong><?= $i ?></strong>
                                <?php else: ?>
                                    <a href="?pagina=<?= $i ?>&itens=<?= $itens_por_pagina ?>&ordem=<?= $ordem ?>&direcao=<?= $direcao ?>"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <!-- Próximo -->
                            <?php if ($pagina_atual < $total_paginas): ?>
                                <a href="?pagina=<?= $pagina_atual + 1 ?>&itens=<?= $itens_por_pagina ?>&ordem=<?= $ordem ?>&direcao=<?= $direcao ?>">Próximo ▶</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </section>
    
    </div>
</body>
</html>
