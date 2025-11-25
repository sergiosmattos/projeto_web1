<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';

date_default_timezone_set('America/Sao_Paulo');
$rodapeDataHora = date('d/m/Y H:i');

$obraRepo = new ObraRepositorio($pdo);
$produtoRepositorio = new ProdutoRepositorio($pdo, $obraRepo);
$produtos = $produtoRepositorio->listar();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body, table, th, td, h3 {
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 20px;
        }

        h3 {
            text-align: center;
            margin: 10px 0 20px 0;
            color: #333;
            border-bottom: 3px solid #6a5acd;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        table th {
            padding: 10px 8px;
            font-weight: bold;
            background-color: #6a5acd;
            color: white;
            text-align: left;
        }

        table td {
            padding: 8px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .pdf-footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .total-produtos {
            text-align: right;
            margin-top: 15px;
            font-weight: bold;
            font-size: 12px;
        }

        .header-info {
            text-align: center;
            margin-bottom: 5px;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>

<div class="header-info">
    Geek Store - Sistema de Gestão de Produtos
</div>

<h3>Relatório de Produtos</h3>

<table>
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Obra</th>
            <th class="text-center">Quantidade</th>
            <th class="text-right">Preço Unitário</th>
            <th class="text-right">Valor Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $valorTotalGeral = 0;
        foreach ($produtos as $produto): 
            $valorTotal = $produto->getPreco() * $produto->getQuantidade();
            $valorTotalGeral += $valorTotal;
        ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($produto->getId()) ?></td>
                <td><?= htmlspecialchars($produto->getNome()) ?></td>
                <td><?= htmlspecialchars($produto->getDescricao()) ?></td>
                <td><?= htmlspecialchars($produto->getObra()->getNome()) ?></td>
                <td class="text-center"><?= htmlspecialchars($produto->getQuantidade()) ?></td>
                <td class="text-right">R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></td>
                <td class="text-right">R$ <?= number_format($valorTotal, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold; background-color: #f0f0f0;">TOTAL GERAL:</td>
            <td class="text-right" style="font-weight: bold; background-color: #f0f0f0;">R$ <?= number_format($valorTotalGeral, 2, ',', '.') ?></td>
        </tr>
    </tfoot>
</table>

<div class="total-produtos">
    Total de produtos cadastrados: <?= count($produtos) ?>
</div>

<div class="pdf-footer">
    Relatório gerado em: <?= htmlspecialchars($rodapeDataHora) ?> | Geek Store - Gestão de Produtos
</div>

</body>
</html>