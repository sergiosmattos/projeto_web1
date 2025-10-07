<?php

session_start();

require __DIR__.'/src/repositorio/UsuarioRepositorio.php';

// if ( $_SERVER['REQUEST_METHOD' !== "POST"] ) {
//     header('Location: login.php');
//     exit;
// }

var_dump($_POST);

$email = trim($_POST['email']) ?? '';
$senha = trim($_POST['senha']) ?? '';

if( $email === '' || $senha === '' ){
    header('Location: login.php?erro=campos');
    exit;
}

$usuarioRepositorio = new UsuarioRepositorio($pdo);

if( $usuarioRepositorio->autenticarByEmailSenha($email, $senha)){

    session_regenerate_id(true);
    $_SESSION['usuario'] = $email;

    header('Location: dashboardAdmin.php');
    exit;

}

header('Location: login.php?erro=credenciais');
exit;

?>