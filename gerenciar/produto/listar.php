<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

    include_once(DIR_PROJETOWEB."/reutilizar/verify-logged.php");
    include_once(DIR_PROJETOWEB."/reutilizar/verify-admin.php");

    $obraRepo = new ObraRepositorio($pdo);

    $produtoRepositorio = new ProdutoRepositorio($pdo, $obraRepo);

    // Paginação
    $itens_por_pagina = $_GET['itens_por_pagina'] ?? 10;
    $pagina_atual = $_GET['pagina'] ?? 1;
    $offset = ($pagina_atual - 1) * $itens_por_pagina;

    // Ordenação
    $ordem = $_GET['ordem'] ?? null;
    $direcao = $_GET['direcao'] ?? 'ASC';

    // Buscar dados
    $total_categorias = $produtoRepositorio->contarTotal();
    $total_paginas = ceil($total_categorias / $itens_por_pagina);
    $produtos = $produtoRepositorio->listarPaginado($itens_por_pagina, $offset, $ordem, $direcao);
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
    <title>Gerenciar - Produtos</title>
</head>

<body>
    
    <?php include DIR_PROJETOWEB . '/reutilizar/header.php' ?>
    <?php include DIR_PROJETOWEB . '/reutilizar/asidemenu.php' ?>

    <div class="container-listar">

        <h1>Gerenciar Produtos</h1>

        <div class="container-topo">
            <a href="form.php"><button class="botao-adicionar">Adicionar Produto</button></a>
            <a href="geradorPdf.php" target="_blank"><button class="botao-adicionar">Gerar PDF</button></a>

            <div class="barra-pesquisar">
                <input type="text" placeholder="Pesquisar obra...">
            </div>
        </div>

        <section class="container-tabela">

            <div class="numero-paginacao">
                <form method="GET" action="" class="form-itens-pagina">
                    <label for="itens_por_pagina">Itens por página:</label>
                    <select name="itens_por_pagina" id="itens_por_pagina" onchange="this.form.submit()">
                        <option value="5" <?= $itens_por_pagina == 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $itens_por_pagina == 10 ? 'selected' : '' ?>>10</option>
                        <option value="20" <?= $itens_por_pagina == 20 ? 'selected' : '' ?>>20</option>
                        <option value="50" <?= $itens_por_pagina == 50 ? 'selected' : '' ?>>50</option>
                    </select>

                    <input type="hidden" name="ordem" value="<?= htmlspecialchars($ordem ?? '')?>">
                    <input type="hidden" name="direcao" value="<?= htmlspecialchars($direcao) ?>">
                    
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>
                            <div class="nomeColuna">
                                <a href="?ordem=nome_produto&direcao=<?= $ordem == 'nome_produto' && $direcao == 'ASC' ? 'DESC' : 'ASC' ?>&itens=<?= $itens_por_pagina ?>">
                                Nome ⟳
                                <?php if($ordem == 'nome_categoria'): ?>
                                    <?= $direcao == 'ASC' ? '⭡A' : '⭣Z' ?>
                                <?php endif; ?>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="nomeColuna">
                                <a href="?ordem=descricao_produto&direcao=<?= $ordem == 'descricao_produto' && $direcao == 'ASC' ? 'DESC' : 'ASC' ?>&itens=<?= $itens_por_pagina ?>">
                                Descrição ⟳
                                <?php if($ordem == 'descricao_produto'): ?>
                                    <?= $direcao == 'ASC' ? '⭡A' : '⭣Z' ?>
                                <?php endif; ?>
                                </a>
                            </div>
                        </th>
                        <th>Quantidade</th>
                        <th>
                            
                            <div class="nomeColuna">
                                <a href="?ordem=preco_produto&direcao=<?= $ordem == 'preco_produto' && $direcao == 'ASC' ? 'DESC' : 'ASC' ?>&itens=<?= $itens_por_pagina ?>">
                                Preço ⟳
                                <?php if($ordem == 'preco_produto'): ?>
                                    <?= $direcao == 'ASC' ? '⭡A' : '⭣Z' ?>
                                <?php endif; ?>
                                </a>
                            </div>
                        </th>
                        <th>Obra</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= $produto->getId() ?></td>
                            <td>

                                <img 
                                    src="/projeto_web1/<?= htmlspecialchars($produto->getImagemDiretorio()) ?>" 
                                    alt="<?= htmlspecialchars($produto->getNome()) ?>"
                                    class="imagemList"
                                >

                            </td>
                            <td><?= htmlspecialchars($produto->getNome()) ?></td>
                            <td><?= htmlspecialchars($produto->getDescricao()) ?></td>
                            <td><?= htmlspecialchars($produto->getQuantidade()) ?>
                            <td>R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></td>
                            <td><?= $produto->getObra()->getNome() ?></td>

                            <td>
                                <div class="td-acoes">
                                    <form action="excluir.php" method="post">
                                        <input type="hidden" name="id" value="<?= $produto->getId() ?>">
                                        <input type="submit" class="botao-excluir" value="Excluir">
                                    </form>

                                    <form action="form.php" method="post">
                                        <input type="hidden" name="id" value="<?= $produto->getId() ?>">
                                        <input type="submit" class="botao-editar" value="Editar">
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

            <div class="container-paginacao">
                <div class="paginacao">
                    <?php if ($total_paginas > 1): ?>
                        <?php if ($pagina_atual > 1): ?>
                            <a href="?pagina=<?= $pagina_atual - 1 ?>&ordem=<?= htmlspecialchars($ordem ?? '') ?>&direcao=<?= htmlspecialchars($direcao) ?>&itens_por_pagina=<?= $itens_por_pagina ?>">« Anterior</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <?php if ($i == $pagina_atual): ?>
                                <strong class="pagina-atual"><?= $i ?></strong>
                            <?php else: ?>
                                <a href="?pagina=<?= $i ?>&ordem=<?= htmlspecialchars($ordem ?? '') ?>&direcao=<?= htmlspecialchars($direcao) ?>&itens_por_pagina=<?= $itens_por_pagina ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagina_atual < $total_paginas): ?>
                            <a href="?pagina=<?= $pagina_atual + 1 ?>&ordem=<?= htmlspecialchars($ordem ?? '') ?>&direcao=<?= htmlspecialchars($direcao) ?>&itens_por_pagina=<?= $itens_por_pagina ?>">Próximo »</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>

        </section>

    </div>

</body>
</html>