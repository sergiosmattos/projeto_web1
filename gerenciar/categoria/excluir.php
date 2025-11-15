<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require DIR_PROJETOWEB . 'src/repositorio/CategoriaRepositorio.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: listar.php');
    exit;
}

$categoriaRepositorio = new CategoriaRepositorio($pdo);
$categoriaRepositorio->remover($_POST['id']);

header("Location: listar.php");
