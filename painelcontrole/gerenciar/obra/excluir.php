<?php

require __DIR__ . "/../../../src/conexaoBD.php";
require __DIR__ . "/../../../src/modelo/Obra.php";
require __DIR__ . "/../../src/repositorio/ObraRepositorio.php";

$obraRepositorio = new ObraRepositorio($pdo);
$obraRepositorio->remover($_POST['id']);

header("Location: listar.php");

