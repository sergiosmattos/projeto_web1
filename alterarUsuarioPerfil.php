<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
    require DIR_PROJETOWEB . 'src/repositorio/UsuarioRepositorio.php';

    session_start();

    if( $_SERVER["REQUEST_METHOD"] !== "POST" ){
        header('Location: login.php');
        exit();
    }

    $emailUsuario = $_SESSION['usuario'] ?? null;
    if(!$emailUsuario) {
        header('Location: login.php');
        exit;
    }

    $usuarioRepositorio = new UsuarioRepositorio($pdo);
    $usuarioExistente = $usuarioRepositorio->findByEmail($emailUsuario);

    $id = $usuarioExistente->getId();
    $tipo = $usuarioExistente->getTipo();
    $nome = $_POST['nome'] ?? $usuarioExistente->getNome();
    $email = $_POST['email'] ?? $usuarioExistente->getEmail();
    $senha = $_POST['senha'] ?? $usuarioExistente->getSenha();
    $dataNascimento = $_POST['dataNascimento'] ?? $usuarioExistente->getDataNascimento()->format('Y-m-d');


        // Valida campos obrigatórios
    if ($nome === '' || $email === '' || $senha === '' || $dataNascimento === '') {
        header('Location: perfil.php?erro=campos');
        exit;
    }

    $usuario = new Usuario($id, $tipo, $nome, new DateTime($dataNascimento), $email, $senha);

    $usuarioRepositorio->atualizar($usuario);

    header('Location: perfil.php?editadoregistro=true');
    exit;

?>