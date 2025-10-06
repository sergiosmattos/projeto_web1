<?php

session_start();

require_once __DIR__ . '/src/conexaoBD.php';
require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
require_once __DIR__ . '/src/Modelo/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    header('Location: login.php?erro=campos');
    exit;
}

$repo = new UsuarioRepositorio($pdo);
$usuario = $repo->buscarPorEmailUsuario($email);

if ($repo->autenticar($email, $senha)) {
    session_regenerate_id(true);
    $tipo = $usuario->getTipo();
    $_SESSION['usuario'] = $email;
    $_SESSION['permissoes'] = $tipo === 'Admin' ? ['usuarios.listar',  'produtos.listar'] : ['produtos.listar'];
    
    if ($tipo === 'Admin') {
        header('Location: dashboardAdmin.html');
    } elseif ($tipo === 'User') {
        header('Location: dashboardUser.php');
    }

    exit;
}

header('Location: login.php?erro=credenciais');
exit;