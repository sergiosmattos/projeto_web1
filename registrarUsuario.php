<?php
require __DIR__ . "src/Modelo/Usuario.php";
require __DIR__ . "src/Repositorio/UsuarioRepositorio.php";
require __DIR__ . "src/Repositorio/conexaoBD.php";


$usuarioRepositorio = new UsuarioRepositorio($pdo);

$nome = trim($_POST['nome'] ?? '');
$tipo = trim($_POST['tipo'] ?? 'User');
$dataNascimento = trim($_POST['dataNascimento'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');


if ($nome === '' || dataNascimento === '' || $email === '' || $senha === '' || dataNascimento === '') {
    header("Location: registrar.php?erro=campos");
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO tbUsuario (nome_usuario, tipo_usuario, email_usuario, senha, data) VALUES (?, ?, ?, ?)');
$stmt->execute([$nome, $perfil, $email, password_hash($senha, PASSWORD_DEFAULT)]);

header("Location: login.php?novo=1");

?>
