<?php

session_start();

$emailUsuario = $_SESSION['usuario'] ?? null;
$confirmacao = $_GET['editadoregistro'] ?? false;

if (!isset($emailUsuario)) {
    header('Location: login.php');
    exit;
}

$tipoUsuario = $_SESSION['tipo'] ?? 'User';