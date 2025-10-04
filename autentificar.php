<?php

session_start();

require_once _DIR_ . '/src/conexaoBD.php';
require_once _DIR_ . '/src/Repositorio/UsuarioRepositorio.php';
require_once _DIR_ . '/src/Modelo/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$repo = new UsuarioRepositorio($pdo);
$usuario = $repo->buscarPorEmailUsuario($email);

if ($repo->autenticar($email, $senha)) {
    session_regenerate_id(true);
    $tipo = $usuario->getTipo();
    $_SESSION['usuario'] = $email;
    $_SESSION['permissoes'] = $tipo === 'Admin' ? ['usuarios.listar',  'produtos.listar'] : ['produtos.listar'];
    header('Location: dashboard.php'); // alterado de admin.php
    exit;
}