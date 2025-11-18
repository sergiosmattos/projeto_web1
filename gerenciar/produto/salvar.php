<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ProdutoRepositorio.php';
require_once DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

session_start();

$produtoRepositorio = new ProdutoRepositorio($pdo);
$obraRepositorio = new ObraRepositorio($pdo);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: listar.php');
    exit;
}

$id = $_POST['id'] ?? '';
$id = $id !== '' ? (int)$id : null;

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$idObra = trim($_POST['id_obra'] ?? '');

if ($nome === '' || $descricao === '' || $preco === '' || $idObra === '') {
    header("Location: form.php?erro=campos");
    exit;
}

$obra = $obraRepositorio->findById((int)$idObra);

$produto = new Produto($id, $nome,$descricao, (float)$preco, $obra
);

if ($id) {

    $existente = $produtoRepositorio->findById($id);

    if (!$existente) {
        header('Location: listar.php?erro=inexistente');
        exit;
    }

    $produtoRepositorio->atualizar($produto);
    header('Location: listar.php?editadoregistro=true');
    exit;

} else {

    $produtoRepositorio->cadastrar($produto);
    header('Location: listar.php?novoregistro=true');
    exit;

}
