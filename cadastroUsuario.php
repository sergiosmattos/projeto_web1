<?php

require __DIR__.'/src/repositorio/UsuarioRepositorio.php';

//Verificação

if( $_SERVER["REQUEST_METHOD"] !== "POST" ){
    header('Location: cadastro.php');
    exit();
}

//>>

$timezone = new DateTimeZone('UTC');
$usuarioRepositorio = new UsuarioRepositorio($pdo);

$nome = trim($_POST['nome']) ?? '';
$email = trim($_POST['email']) ?? '';
$senha = trim($_POST['senha']) ?? '';
$dataNascimento = $_POST['dataNascimento'] ?? '';

$dataNascimento = isset($dataNascimento) ? new DateTime($dataNascimento, $timezone) : '';

// $senha = password_hash($senha, PASSWORD_DEFAULT);

// Verificação

if ( $nome === '' || $email === '' || $senha === '' || $dataNascimento === '' ) {

    header('Location: cadastro.php?erro=campos');
    exit;

}

//>>

$usuario = new Usuario(null, null, $nome, $dataNascimento, $email, $senha);

$usuarioRepositorio->cadastrar($usuario);

header('Location: login.php?novoregistro=true');

?>
