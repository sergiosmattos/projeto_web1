<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: listar.php');
    exit;
}

$obraRepositorio = new ObraRepositorio($pdo);
$obraRepositorio->remover($_POST['id']);

header("Location: listar.php");
