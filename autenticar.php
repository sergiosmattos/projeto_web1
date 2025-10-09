<?php

session_start();

require __DIR__.'/src/repositorio/UsuarioRepositorio.php';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

if ( $requestMethod !== "POST" ) {
    header('Location: login.php');
    exit;
}

// print('var dump do post: ');
// var_dump($_POST);

$email = trim($_POST['email']) ?? '';
$senha = trim($_POST['senha']) ?? '';

if( $email === '' || $senha === '' ){
    header('Location: login.php?erro=campos');
    exit;
}

$usuarioRepositorio = new UsuarioRepositorio($pdo);

if( $usuarioRepositorio->autenticarByEmailSenha($email, $senha)){
    
    $usuario = $usuarioRepositorio->findByEmail($email);
    $tipo = $usuario->getTipo();

    session_regenerate_id(true);
    $_SESSION['usuario'] = $email;
    $_SESSION['tipo'] = $tipo;

    header('Location: dashboardAdmin.php');
    exit;

}

header('Location: login.php?erro=credenciais');
exit;

?>