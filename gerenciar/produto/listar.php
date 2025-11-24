<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

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

$obraRepo = new ObraRepositorio($pdo);

$produtoRepositorio = new ProdutoRepositorio($pdo, $obraRepo);

// Configuração da paginação
$itens_por_pagina = filter_input(INPUT_GET, 'itens_por_pagina', FILTER_VALIDATE_INT) ?: 10;

// Pega o número da página atual
$pagina_atual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;

// Calcula o offset
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// Parâmetros de ordenação
$ordem = filter_input(INPUT_GET, 'ordem') ?: null;
$direcao = filter_input(INPUT_GET, 'direcao') ?: 'ASC';

// Busca total de registros e calcula total de páginas
$total_produtos = $produtoRepositorio->contarTotal();
$total_paginas = ceil($total_produtos / $itens_por_pagina);

// Busca produtos da página atual com ordenação
$produtos = $produtoRepositorio->listarPaginado($itens_por_pagina, $offset, $ordem, $direcao);

// Função para gerar URLs de ordenação
function gerarUrlOrdenacao($campo, $paginaAtual, $ordemAtual, $direcaoAtual, $itensPorPagina) {
    $novaDirecao = ($ordemAtual === $campo && $direcaoAtual === 'ASC') ? 'DESC' : 'ASC';
    return "?pagina={$paginaAtual}&ordem={$campo}&direcao={$novaDirecao}&itens_por_pagina={$itensPorPagina}";
}

// Função para mostrar ícone de ordenação
function mostrarIconeOrdenacao($campo, $ordemAtual, $direcaoAtual) {
    if ($ordemAtual !== $campo) {
        return '⇅';
    }
    return $direcaoAtual === 'ASC' ? '↑' : '↓';
}
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

                    <input type="hidden" name="ordem" value="<?= htmlspecialchars($ordem ?? '') ?>">
                    <input type="hidden" name="direcao" value="<?= htmlspecialchars($direcao) ?>">
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>
                            <a href="<?= gerarUrlOrdenacao('nome_produto', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>" 
                               style="color: inherit; text-decoration: none; cursor: pointer;">
                                Nome <?= mostrarIconeOrdenacao('nome_produto', $ordem, $direcao) ?>
                            </a>
                        </th>
                        <th>Descrição</th>
                        <th>
                            <a href="<?= gerarUrlOrdenacao('quantidade_produto', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>" 
                               style="color: inherit; text-decoration: none; cursor: pointer;">
                                Quantidade <?= mostrarIconeOrdenacao('quantidade_produto', $ordem, $direcao) ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= gerarUrlOrdenacao('preco_produto', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>" 
                               style="color: inherit; text-decoration: none; cursor: pointer;">
                                Preço <?= mostrarIconeOrdenacao('preco_produto', $ordem, $direcao) ?>
                            </a>
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