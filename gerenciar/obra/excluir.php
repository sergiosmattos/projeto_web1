<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require DIR_PROJETOWEB . 'src/repositorio/ObraRepositorio.php';

$obraRepositorio = new ObraRepositorio($pdo);
$obraRepositorio->remover($_POST['id']);

header("Location: listar.php");
