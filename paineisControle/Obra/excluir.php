<?php

require __DIR__ . "/../../src/conexaoBD.php";
require __DIR__ . "/../../src/Modelo/Obra.php";
require __DIR__ . "/../src/Repositorio/ObraRepositorio.php";

$obraRepositorio = new ObraRepositorio($pdo);
$obraRepositorio->remover($_POST['id']);

header("Location: listar.php");

