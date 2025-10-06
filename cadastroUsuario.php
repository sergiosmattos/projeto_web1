<?php
require __DIR__.'/src/repositorio/UsuarioRepositorio.php';

//Verificação

if( $_SESSION["REQUEST_METHOD"] !== "post" ){
    header('Location: cadastro.php');
    exit();
}

//>>

$usuarioRepositorio = new UsuarioRepositorio($pdo);



?>
